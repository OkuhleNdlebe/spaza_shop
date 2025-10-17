<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Store;
use App\Models\SalesPrediction;
use App\Models\InventoryForecast;

class TestPredictions extends Command
{
    protected $signature = 'predictions:test';
    protected $description = 'Test predictions generation';

    public function handle()
    {
        $this->info('Testing predictions generation...');
        
        // Check basic data
        $products = Product::count();
        $stores = Store::count();
        
        $this->info("Products: {$products}, Stores: {$stores}");
        
        if ($products == 0 || $stores == 0) {
            $this->warn('Need products and stores to generate predictions.');
            $this->info('Creating sample data...');
            $this->createSampleData();
        }
        
        // Test prediction generation
        $controller = new \App\Http\Controllers\PredictiveAnalyticsController();
        $controller->generatePredictions();
        
        // Check results
        $predictions = SalesPrediction::count();
        $forecasts = InventoryForecast::count();
        
        $this->info("Created {$predictions} predictions and {$forecasts} forecasts");
        
        if ($predictions > 0) {
            $this->info('First prediction:');
            $first = SalesPrediction::first();
            dump($first->toArray());
        }
        
        return Command::SUCCESS;
    }
    
    private function createSampleData()
    {
        // Create a sample store if none exists
        if (Store::count() == 0) {
            Store::create([
                'name' => 'Test Store',
                'location' => 'Test Location',
                'owner_name' => 'Test Owner',
                'contact_number' => '1234567890'
            ]);
            $this->info('Created test store');
        }
        
        // Create a sample product if none exists
        if (Product::count() == 0) {
            // First create a supplier and manufacturer if needed
            $supplier = \App\Models\Supplier::firstOrCreate([
                'company_name' => 'Test Supplier'
            ], [
                'contact_person' => 'Test Contact',
                'phone_number' => '1234567890',
                'email' => 'test@supplier.com',
                'address' => 'Test Address'
            ]);
            
            $manufacturer = \App\Models\Manufacturer::firstOrCreate([
                'name' => 'Test Manufacturer'
            ], [
                'contact_email' => 'test@manufacturer.com',
                'address' => 'Test Address'
            ]);
            
            Product::create([
                'name' => 'Test Product',
                'description' => 'Test Description',
                'manufacturer_id' => $manufacturer->id,
                'supplier_id' => $supplier->id,
                'expiry_date' => now()->addYear(),
                'price' => 10.99
            ]);
            $this->info('Created test product');
        }
    }
}