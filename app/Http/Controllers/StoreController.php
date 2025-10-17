<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StoreController extends Controller
{
    // Display all stores
    public function index(Request $request)
{
    $query = Store::query();
    
    if ($request->has('search')) {
        $search = $request->search;
        $query->where('name', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%")
              ->orWhere('owner_name', 'like', "%{$search}%");
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
    $lowStockProducts = $store->lowStockProducts;

    
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
        ]);

        $store = Store::create($request->all());

        return redirect()->route('stores.show', $store->id)->with('success', 'Store created successfully.');
    }

    // Generate and display QR code for a store
    public function generateQRCode($id)
    {
        $store = Store::findOrFail($id);
        $qrcode = QrCode::size(200)->generate(route('stores.show', $store->id));

        return response($qrcode)->header('Content-Type', 'image/png');
    }
}
