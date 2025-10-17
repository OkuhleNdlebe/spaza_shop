<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Manufacturer;

class BulkProductController extends Controller
{
    /**
     * Show bulk operations page
     */
    public function index()
    {
        return view('products.bulk');
    }

    /**
     * Export products to CSV
     */
    public function export()
    {
        $products = Product::with(['supplier', 'manufacturer'])->get();
        
        $csvFileName = 'products_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");
            
            // CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Description',
                'Manufacturer',
                'Supplier',
                'Price',
                'Expiry Date',
                'Created At',
                'Updated At'
            ]);
            
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->description,
                    $product->manufacturer->name ?? 'N/A',
                    $product->supplier->company_name ?? 'N/A',
                    $product->price,
                    $product->expiry_date,
                    $product->created_at,
                    $product->updated_at
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Import products from CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);
        
        try {
            $file = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($file->getPathname()));
            
            // Remove header
            $header = array_shift($csvData);
            
            $importedCount = 0;
            
            foreach ($csvData as $row) {
                if (count($row) < 3) continue; // Skip invalid rows
                
                // Find or create supplier
                $supplier = Supplier::firstOrCreate(
                    ['company_name' => $row[3] ?? 'Unknown Supplier'],
                    [
                        'contact_person' => 'Imported',
                        'phone_number' => '000-000-0000',
                        'email' => 'imported@example.com',
                        'address' => 'Imported Address'
                    ]
                );
                
                // Find or create manufacturer
                $manufacturer = Manufacturer::firstOrCreate(
                    ['name' => $row[2] ?? 'Unknown Manufacturer'],
                    [
                        'contact_email' => 'manufacturer@example.com',
                        'address' => 'Manufacturer Address'
                    ]
                );
                
                // Create product
                Product::create([
                    'name' => $row[0],
                    'description' => $row[1],
                    'manufacturer_id' => $manufacturer->id,
                    'supplier_id' => $supplier->id,
                    'price' => $row[4] ?? 0,
                    'expiry_date' => $row[5] ?? now()->addYear(),
                ]);
                
                $importedCount++;
            }
            
            return redirect()->route('products.index')
                ->with('success', "Successfully imported {$importedCount} products!");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Download CSV template
     */
    public function downloadTemplate()
    {
        $csvFileName = 'products_import_template.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");
            
            // CSV headers with example data
            fputcsv($file, ['Product Name', 'Description', 'Manufacturer', 'Supplier', 'Price', 'Expiry Date (YYYY-MM-DD)']);
            fputcsv($file, ['Example Product', 'This is a sample product', 'Example Manufacturer', 'Example Supplier', '19.99', '2024-12-31']);
            fputcsv($file, ['Another Product', 'Another description', 'Another Manufacturer', 'Another Supplier', '29.99', '2024-06-30']);
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}