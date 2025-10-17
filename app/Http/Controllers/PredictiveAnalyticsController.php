<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Store;
use App\Models\SalesPrediction;
use App\Models\InventoryForecast;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;

class PredictiveAnalyticsController extends Controller
{
    public function dashboard()
    {
        $predictions = SalesPrediction::with(['product', 'store'])
            ->where('for_date', '>=', now())
            ->orderBy('for_date')
            ->take(10)
            ->get();

        $forecasts = InventoryForecast::with(['product', 'store'])
            ->where('stockout_probability', '>', 0.3)
            ->orderBy('stockout_probability', 'desc')
            ->take(10)
            ->get();

        return view('analytics.dashboard', compact('predictions', 'forecasts'));
    }

    public function generatePredictions()
{
    try {
        \Log::info('Starting predictions generation...');
        
        // Clear existing predictions
        SalesPrediction::truncate();
        InventoryForecast::truncate();
        \Log::info('Cleared existing predictions');

        // Check if we have basic data
        $productCount = Product::count();
        $storeCount = Store::count();
        
        \Log::info("Products: {$productCount}, Stores: {$storeCount}");

        // Generate sales predictions for next 30 days
        $this->generateSalesPredictions();
        
        // Generate inventory forecasts
        $this->generateInventoryForecasts();
        
        // Check what was created
        $predictionCount = SalesPrediction::count();
        $forecastCount = InventoryForecast::count();
        
        \Log::info("Created - Predictions: {$predictionCount}, Forecasts: {$forecastCount}");
        
        return redirect()->route('analytics.dashboard')
            ->with('success', "Predictions generated successfully! Created {$predictionCount} predictions and {$forecastCount} forecasts.");
            
    } catch (\Exception $e) {
        \Log::error('Error generating predictions: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        return redirect()->route('analytics.dashboard')
            ->with('error', 'Error generating predictions: ' . $e->getMessage());
    }
}

   private function generateSalesPredictions()
{
    $products = Product::with(['sales' => function($query) {
        $query->where('sale_date', '>=', now()->subDays(90));
    }])->get();

    // If no products exist, create basic predictions
    if ($products->isEmpty()) {
        $this->createBasicPredictions();
        return;
    }

    foreach ($products as $product) {
        // Get historical sales data as array
        $historicalData = $product->sales->groupBy(function($sale) {
            return $sale->sale_date->format('Y-m-d');
        })->map(function($daySales) {
            return $daySales->count(); // Number of sales per day
        });

        // Convert to array for calculations
        $historicalArray = $historicalData->values()->toArray();

        // If no historical sales, use default prediction
        if (empty($historicalArray)) {
            $prediction = rand(3, 8); // Random default prediction
            $confidence = 0.3; // Low confidence
        } else {
            $prediction = $this->calculateMovingAverage($historicalArray);
            $confidence = $this->calculateConfidenceLevel($historicalArray);
        }

        // Get stores to associate predictions with
        $stores = Store::all();
        if ($stores->isEmpty()) {
            $stores = [null]; // Fallback if no stores
        }

        foreach ($stores as $store) {
            foreach (range(1, 30) as $day) {
                $forDate = now()->addDays($day);
                
                SalesPrediction::create([
                    'product_id' => $product->id,
                    'store_id' => $store ? $store->id : 1,
                    'predicted_quantity' => $prediction,
                    'confidence_level' => $confidence,
                    'prediction_date' => now(),
                    // FIX: Remove format() - let Eloquent handle the date conversion
                    'for_date' => $forDate, // Pass Carbon instance directly
                    'factors' => json_encode([
                        'historical_days' => count($historicalArray),
                        'seasonality' => $this->getSeasonalityFactor($forDate),
                        'trend' => empty($historicalArray) ? 1.0 : $this->calculateTrend($historicalArray),
                        'prediction_type' => empty($historicalArray) ? 'default' : 'calculated'
                    ])
                ]);
            }
        }
    }
}
    /**
     * Create basic predictions when no products exist
     */
    /**
 * Create basic predictions when no products exist
 */
private function createBasicPredictions()
{
    $products = Product::all();
    $stores = Store::all();

    if ($products->isEmpty() || $stores->isEmpty()) {
        // Create at least one prediction to show something
        SalesPrediction::create([
            'product_id' => 1,
            'store_id' => 1,
            'predicted_quantity' => 5,
            'confidence_level' => 0.5,
            'prediction_date' => now(),
            'for_date' => now()->addDays(1), // Carbon instance
            'factors' => json_encode(['note' => 'Default prediction - no data available'])
        ]);
        return;
    }

    foreach ($products as $product) {
        foreach ($stores as $store) {
            foreach (range(1, 7) as $day) { // Only 7 days for basic predictions
                $forDate = now()->addDays($day);
                
                SalesPrediction::create([
                    'product_id' => $product->id,
                    'store_id' => $store->id,
                    'predicted_quantity' => rand(3, 10),
                    'confidence_level' => 0.3,
                    'prediction_date' => now(),
                    'for_date' => $forDate, // Carbon instance
                    'factors' => json_encode([
                        'historical_days' => 0,
                        'seasonality' => 1.0,
                        'trend' => 1.0,
                        'note' => 'Based on default prediction (no sales data)'
                    ])
                ]);
            }
        }
    }
}

/**
 * Create basic inventory forecasts when no data exists
 */
private function createBasicInventoryForecasts()
{
    $products = Product::all();
    $stores = Store::all();

    if ($products->isEmpty() || $stores->isEmpty()) {
        // Create at least one forecast to show something
        InventoryForecast::create([
            'product_id' => 1,
            'store_id' => 1,
            'current_stock' => 10,
            'predicted_demand' => 5,
            'recommended_order' => 5,
            'stockout_risk_date' => now()->addDays(2), // Carbon instance
            'stockout_probability' => 0.6,
            'forecast_date' => now(),
            'for_date' => now()->addDays(7) // Carbon instance
        ]);
        return;
    }

    foreach ($products as $product) {
        foreach ($stores as $store) {
            InventoryForecast::create([
                'product_id' => $product->id,
                'store_id' => $store->id,
                'current_stock' => rand(0, 20),
                'predicted_demand' => rand(3, 8),
                'recommended_order' => rand(5, 15),
                'stockout_risk_date' => now()->addDays(rand(1, 5)), // Carbon instance
                'stockout_probability' => rand(30, 80) / 100,
                'forecast_date' => now(),
                'for_date' => now()->addDays(7) // Carbon instance
            ]);
        }
    }
}

  private function generateInventoryForecasts()
{
    $storeProducts = DB::table('store_product')
        ->join('products', 'store_product.product_id', '=', 'products.id')
        ->select('store_product.*', 'products.name as product_name')
        ->get();

    // If no store products exist, create basic forecasts
    if ($storeProducts->isEmpty()) {
        $this->createBasicInventoryForecasts();
        return;
    }

    foreach ($storeProducts as $item) {
        $salesPrediction = SalesPrediction::where('product_id', $item->product_id)
            ->where('store_id', $item->store_id)
            ->where('for_date', now()->addDays(7))
            ->first();

        $predictedDemand = $salesPrediction ? $salesPrediction->predicted_quantity : rand(3, 8);
        $currentStock = $item->quantity ?? 0;
        
        // Avoid division by zero
        $daysOfSupply = $predictedDemand > 0 ? floor($currentStock / $predictedDemand) : 999;

        $stockoutRisk = $this->calculateStockoutRisk($currentStock, $predictedDemand);

        InventoryForecast::create([
            'product_id' => $item->product_id,
            'store_id' => $item->store_id,
            'current_stock' => $currentStock,
            'predicted_demand' => $predictedDemand,
            'recommended_order' => max(0, $predictedDemand * 2 - $currentStock),
            'stockout_risk_date' => $daysOfSupply < 7 ? now()->addDays($daysOfSupply) : null,
            'stockout_probability' => $stockoutRisk,
            'forecast_date' => now(),
            // FIX: Remove format() here too
            'for_date' => now()->addDays(7) // Pass Carbon instance directly
        ]);
    }
}

public function createSamplePredictions()
{
    try {
        // Clear existing
        SalesPrediction::truncate();
        InventoryForecast::truncate();
        
        // Get or create sample data
        $store = Store::first();
        $product = Product::first();
        
        if (!$store || !$product) {
            return "Need at least one store and one product";
        }
        
        // Create sample sales predictions
        for ($i = 1; $i <= 7; $i++) {
            SalesPrediction::create([
                'product_id' => $product->id,
                'store_id' => $store->id,
                'predicted_quantity' => rand(5, 15),
                'confidence_level' => rand(60, 90) / 100,
                'prediction_date' => now(),
                'for_date' => now()->addDays($i),
                'factors' => json_encode(['type' => 'sample'])
            ]);
        }
        
        // Create sample inventory forecasts
        InventoryForecast::create([
            'product_id' => $product->id,
            'store_id' => $store->id,
            'current_stock' => 20,
            'predicted_demand' => 8,
            'recommended_order' => 5,
            'stockout_risk_date' => now()->addDays(3),
            'stockout_probability' => 0.7,
            'forecast_date' => now(),
            'for_date' => now()->addDays(7)
        ]);
        
        $predictionCount = SalesPrediction::count();
        $forecastCount = InventoryForecast::count();
        
        return "Created {$predictionCount} predictions and {$forecastCount} forecasts";
        
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

    /**
     * Create basic inventory forecasts when no data exists
     */
    // private function createBasicInventoryForecasts()
    // {
    //     $products = Product::all();
    //     $stores = Store::all();

    //     if ($products->isEmpty() || $stores->isEmpty()) {
    //         // Create at least one forecast to show something
    //         InventoryForecast::create([
    //             'product_id' => 1,
    //             'store_id' => 1,
    //             'current_stock' => 10,
    //             'predicted_demand' => 5,
    //             'recommended_order' => 5,
    //             'stockout_risk_date' => now()->addDays(2),
    //             'stockout_probability' => 0.6,
    //             'forecast_date' => now(),
    //             'for_date' => now()->addDays(7)
    //         ]);
    //         return;
    //     }

    //     foreach ($products as $product) {
    //         foreach ($stores as $store) {
    //             InventoryForecast::create([
    //                 'product_id' => $product->id,
    //                 'store_id' => $store->id,
    //                 'current_stock' => rand(0, 20),
    //                 'predicted_demand' => rand(3, 8),
    //                 'recommended_order' => rand(5, 15),
    //                 'stockout_risk_date' => now()->addDays(rand(1, 5)),
    //                 'stockout_probability' => rand(30, 80) / 100,
    //                 'forecast_date' => now(),
    //                 'for_date' => now()->addDays(7)
    //             ]);
    //         }
    //     }
    // }

    // FIXED: These methods now accept arrays instead of Collections
    private function calculateMovingAverage(array $historicalData, $period = 7)
    {
        if (count($historicalData) < $period) {
            return array_sum($historicalData) / max(1, count($historicalData));
        }
        
        $recentValues = array_slice($historicalData, -$period);
        return array_sum($recentValues) / $period;
    }

    private function calculateConfidenceLevel(array $historicalData)
    {
        $dataCount = count($historicalData);
        if ($dataCount < 7) return 0.3;
        if ($dataCount < 30) return 0.6;
        return min(0.95, 0.7 + ($dataCount / 100));
    }

    private function calculateTrend(array $historicalData)
    {
        if (count($historicalData) < 2) {
            return 1.0;
        }
        
        $firstHalf = array_slice($historicalData, 0, floor(count($historicalData) / 2));
        $secondHalf = array_slice($historicalData, floor(count($historicalData) / 2));
        
        $firstAvg = array_sum($firstHalf) / count($firstHalf);
        $secondAvg = array_sum($secondHalf) / count($secondHalf);
        
        if ($firstAvg == 0) return 1.0;
        
        return $secondAvg / $firstAvg;
    }

    private function getSeasonalityFactor($date)
    {
        // Simple seasonality - you can enhance this
        $month = $date->month;
        
        // Higher sales in summer months (example for Southern Africa)
        if ($month >= 11 || $month <= 2) {
            return 1.2; // Summer
        } elseif ($month >= 6 && $month <= 8) {
            return 0.8; // Winter
        }
        
        return 1.0; // Normal season
    }

    private function calculateStockoutRisk($currentStock, $predictedDemand)
    {
        if ($predictedDemand <= 0) return 0.0;
        
        $daysOfSupply = $currentStock / $predictedDemand;
        
        if ($daysOfSupply >= 14) return 0.1;
        if ($daysOfSupply >= 7) return 0.3;
        if ($daysOfSupply >= 3) return 0.6;
        if ($daysOfSupply >= 1) return 0.8;
        return 0.95;
    }
}