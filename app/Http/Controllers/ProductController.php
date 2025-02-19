<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        // Fetch all products with their associated suppliers
        $products = Product::with('supplier')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product assigned to a supplier.
     */
    public function create()
    {
        // Fetch all suppliers
        $suppliers = Supplier::all();
        return view('products.create', compact('suppliers'));
    }

    /**
     * Store a newly created product and generate its QR code.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'manufacturer' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
        ]);

        // Create the product
        $product = Product::create($request->all());

        // Generate QR code content (URL pointing to the product details page)
        $qrCodeData = route('products.show', $product->id);

        // Generate and store the QR code
        $qrCodeImage = QrCode::size(200)->generate($qrCodeData);
        $product->qr_code = $qrCodeImage; // Store QR code in the product's `qr_code` column
        $product->save();

        // Redirect to the supplier's page with success message
        return redirect()->route('suppliers.show', $product->supplier_id)
                         ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product with its QR code.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
