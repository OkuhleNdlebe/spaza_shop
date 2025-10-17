<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function reports()
{
    $stores = Store::all(); // Add this line
    return view('sales.reports', compact('stores')); // Update this line
}
    public function index()
    {
        $sales = Sale::with(['store', 'product'])
            ->orderBy('sale_date', 'desc')
            ->paginate(20);

        $totalSales = Sale::sum('total_amount');
        $totalUnits = Sale::sum('quantity');

        return view('sales.index', compact('sales', 'totalSales', 'totalUnits'));
    }

    public function create()
    {
        $stores = Store::all();
        $products = Product::all();

        return view('sales.create', compact('stores', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        // Calculate total amount
        $validated['total_amount'] = $validated['quantity'] * $validated['unit_price'];

        Sale::create($validated);

        // Update store product quantity (reduce stock)
        DB::table('store_product')
            ->where('store_id', $validated['store_id'])
            ->where('product_id', $validated['product_id'])
            ->decrement('quantity', $validated['quantity']);

        return redirect()->route('sales.index')
            ->with('success', 'Sale recorded successfully!');
    }

    public function show(Sale $sale)
    {
        $sale->load(['store', 'product']);
        return view('sales.show', compact('sale'));
    }

    public function dashboard()
    {
        $todaySales = Sale::whereDate('sale_date', today())->sum('total_amount');
        $weekSales = Sale::whereBetween('sale_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount');
        $monthSales = Sale::whereMonth('sale_date', now()->month)->sum('total_amount');

        $topProducts = Sale::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        $recentSales = Sale::with(['store', 'product'])
            ->orderBy('sale_date', 'desc')
            ->take(10)
            ->get();

        return view('sales.dashboard', compact(
            'todaySales', 
            'weekSales', 
            'monthSales', 
            'topProducts', 
            'recentSales'
        ));
    }

    // public function reports()
    // {
    //     return view('sales.reports');
    // }

    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'store_id' => 'nullable|exists:stores,id'
        ]);

        $query = Sale::with(['store', 'product'])
            ->whereBetween('sale_date', [$validated['start_date'], $validated['end_date']]);

        if ($validated['store_id']) {
            $query->where('store_id', $validated['store_id']);
        }

        $sales = $query->get();
        $totalRevenue = $sales->sum('total_amount');
        $totalUnits = $sales->sum('quantity');

        return view('sales.report-results', compact('sales', 'totalRevenue', 'totalUnits', 'validated'));
    }

    public function edit(Sale $sale)
{
    $stores = Store::all();
    $products = Product::all();
    return view('sales.edit', compact('sale', 'stores', 'products'));
}

public function update(Request $request, Sale $sale)
{
    $validated = $request->validate([
        'store_id' => 'required|exists:stores,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'unit_price' => 'required|numeric|min:0',
        'sale_date' => 'required|date',
        'notes' => 'nullable|string'
    ]);

    $validated['total_amount'] = $validated['quantity'] * $validated['unit_price'];
    $sale->update($validated);

    return redirect()->route('sales.show', $sale)
        ->with('success', 'Sale updated successfully!');
}

public function destroy(Sale $sale)
{
    $sale->delete();
    return redirect()->route('sales.index')
        ->with('success', 'Sale deleted successfully!');
}
}