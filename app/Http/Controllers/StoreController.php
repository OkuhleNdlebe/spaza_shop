<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Services\FreeGeocodingService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StoreController extends Controller
{
    protected $geocodingService;
    
    public function __construct(FreeGeocodingService $geocodingService = null)
    {
        $this->geocodingService = $geocodingService ?? new FreeGeocodingService();
    }
    
    // Display all stores
    public function index(Request $request)
    {
        $query = Store::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
        }
        
        $stores = $query->paginate(10);
        
        return view('stores.index', compact('stores'));
    }
    
    // Show a single store
    public function show($id)
    {
        $store = Store::with(['products' => function($query) {
            $query->withPivot('quantity', 'delivered_at', 'expire_date');
        }])->findOrFail($id);
        
        // Get low stock products
        $lowStockProducts = $store->products()
            ->wherePivot('quantity', '<=', $store->low_stock_threshold ?? 5)
            ->get();
        
        // Generate QR code for store
        $qrCode = QrCode::size(200)
            ->backgroundColor(255, 255, 255)
            ->color(0, 0, 0)
            ->margin(1)
            ->generate(route('stores.show', $store->id));
        
        return view('stores.show', compact('store', 'qrCode', 'lowStockProducts'));
    }
    
    // Show the create store form
    public function create()
    {
        return view('stores.create');
    }
    
    // Store a new store in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'low_stock_threshold' => 'nullable|integer|min:1',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ]);
        
        $data = $request->all();
        
        // If coordinates not provided but address is, try to geocode
        if ((empty($data['latitude']) || empty($data['longitude'])) && !empty($data['address'])) {
            $fullAddress = $data['address'];
            if (!empty($data['city'])) $fullAddress .= ', ' . $data['city'];
            if (!empty($data['postal_code'])) $fullAddress .= ' ' . $data['postal_code'];
            $fullAddress .= ', South Africa';
            
            $geocoded = $this->geocodingService->geocodeAddress($fullAddress);
            if ($geocoded) {
                $data['latitude'] = $geocoded['latitude'];
                $data['longitude'] = $geocoded['longitude'];
                if (empty($data['city'])) $data['city'] = $geocoded['city'];
                if (empty($data['postal_code'])) $data['postal_code'] = $geocoded['postal_code'];
            }
        }
        
        $store = Store::create($data);
        
        return redirect()->route('stores.show', $store->id)
            ->with('success', 'Store created successfully!');
    }
    
    // Show edit form
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        return view('stores.edit', compact('store'));
    }
    
    // Update store
    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'low_stock_threshold' => 'nullable|integer|min:1',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ]);
        
        $data = $request->all();
        
        // If address changed and no coordinates provided, geocode new address
        if (($request->filled('address') && $request->address !== $store->address) && 
            (empty($data['latitude']) || empty($data['longitude']))) {
            $fullAddress = $data['address'];
            if (!empty($data['city'])) $fullAddress .= ', ' . $data['city'];
            if (!empty($data['postal_code'])) $fullAddress .= ' ' . $data['postal_code'];
            $fullAddress .= ', South Africa';
            
            $geocoded = $this->geocodingService->geocodeAddress($fullAddress);
            if ($geocoded) {
                $data['latitude'] = $geocoded['latitude'];
                $data['longitude'] = $geocoded['longitude'];
            }
        }
        
        $store->update($data);
        
        return redirect()->route('stores.show', $store->id)
            ->with('success', 'Store updated successfully!');
    }
    
    // Delete store
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        
        // Detach all products first
        $store->products()->detach();
        
        // Delete the store
        $store->delete();
        
        return redirect()->route('stores.index')
            ->with('success', 'Store deleted successfully!');
    }
    
    // Generate QR code for a store
    public function generateQRCode($id)
    {
        $store = Store::findOrFail($id);
        $qrcode = QrCode::size(200)->generate(route('stores.show', $store->id));
        
        return response($qrcode)->header('Content-Type', 'image/png');
    }
}