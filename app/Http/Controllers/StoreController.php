<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StoreController extends Controller
{
    // Display all stores
    public function index()
    {
        $stores = Store::all();
        return view('stores.index', compact('stores'));
    }

    // Show a single store
    public function show($id)
    {
        $store = Store::findOrFail($id);
        $qrCode = QrCode::size(200)->generate(url('/store/' . $store->id));
        return view('stores.show', compact('store',  'qrCode'));
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
