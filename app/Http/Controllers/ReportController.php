<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Product;
use App\Models\Store;
use App\Models\Supplier;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', auth()->id())->get();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function generateSalesReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'store_id' => 'nullable|exists:stores,id'
        ]);

        $data = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'store_id' => $request->store_id
        ];

        // Generate report data
        $reportData = $this->buildSalesReportData($data);
        
        if ($request->has('save_report')) {
            Report::create([
                'name' => 'Sales Report ' . now()->format('Y-m-d'),
                'type' => 'sales',
                'parameters' => $data,
                'user_id' => auth()->id()
            ]);
        }

        $format = $request->get('format', 'html');
        
        if ($format === 'pdf') {
            return $this->generatePdfReport($reportData, 'sales');
        }

        if ($format === 'csv') {
            return $this->generateCsvReport($reportData, 'sales');
        }

        return view('reports.sales', compact('reportData'));
    }

    private function buildSalesReportData($data)
    {
        // Mock sales data - you would replace this with actual sales logic
        $sales = [
            'total_revenue' => 12500.75,
            'total_products_sold' => 245,
            'top_products' => [
                ['name' => 'Bread', 'quantity' => 45, 'revenue' => 675.50],
                ['name' => 'Milk', 'quantity' => 38, 'revenue' => 456.00],
                ['name' => 'Sugar', 'quantity' => 32, 'revenue' => 320.00]
            ],
            'daily_sales' => [
                '2024-01-15' => 1200.50,
                '2024-01-16' => 1350.75,
                '2024-01-17' => 1100.25
            ],
            'period' => [
                'start' => $data['start_date'],
                'end' => $data['end_date']
            ]
        ];

        return $sales;
    }

    private function generatePdfReport($data, $type)
    {
        $pdf = PDF::loadView('reports.pdf.' . $type, compact('data'));
        return $pdf->download('report-' . $type . '-' . now()->format('Y-m-d') . '.pdf');
    }

    private function generateCsvReport($data, $type)
    {
        $filename = 'report-' . $type . '-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Product', 'Quantity Sold', 'Revenue']);
            
            foreach ($data['top_products'] as $product) {
                fputcsv($file, [
                    $product['name'],
                    $product['quantity'],
                    $product['revenue']
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function inventoryReport()
    {
        $lowStock = Product::where('quantity', '<', 5)->count();
        $outOfStock = Product::where('quantity', '<=', 0)->count();
        $totalValue = Product::sum(\DB::raw('price * quantity'));

        return view('reports.inventory', compact('lowStock', 'outOfStock', 'totalValue'));
    }
}