<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Manufacturer;
use App\Models\ExpiryAlert;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $stats = [
        'total_stores' => Store::count(),
        'total_products' => Product::count(),
        'total_suppliers' => Supplier::count(),
        'total_manufacturers' => Manufacturer::count(),
        'recent_stores' => Store::latest()->take(5)->get(),
        'recent_products' => Product::with('supplier', 'manufacturer')->latest()->take(5)->get(),
        'stores_with_products' => Store::has('products')->count(),
        'products_near_expiry' => Product::where('expiry_date', '<=', now()->addDays(30))->count(),
        'total_store_products' => \DB::table('store_product')->count(),
    ];
    $expiringSoon = ExpiryAlert::with(['product', 'store'])
        ->where('days_until_expiry', '<=', 7)
        ->where('notification_sent', false)
        ->get();

        $salesData = [
        'today_sales' => Sale::whereDate('sale_date', today())->sum('total_amount'),
        'week_sales' => Sale::whereBetween('sale_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount'),
        'top_selling' => Sale::select('product_id', \DB::raw('SUM(quantity) as total_sold'))
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'DESC')
            ->take(5)
            ->get()
    ];

    return view('dashboard.dashboard', compact('stats', 'expiringSoon', 'salesData'));
}
}