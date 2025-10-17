<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckProductExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
   

    // app/Console/Commands/CheckProductExpiry.php
protected $signature = 'products:check-expiry';
protected $description = 'Check for products nearing expiry';

public function handle()
{
    $threshold = now()->addDays(7); // 7 days warning
    
    $expiringProducts = \DB::table('store_product')
        ->join('products', 'store_product.product_id', '=', 'products.id')
        ->where('store_product.expire_date', '<=', $threshold)
        ->where('store_product.expire_date', '>', now())
        ->select('store_product.*', 'products.name')
        ->get();
    
    foreach ($expiringProducts as $product) {
        ExpiryAlert::updateOrCreate(
            [
                'product_id' => $product->product_id,
                'store_id' => $product->store_id
            ],
            [
                'expiry_date' => $product->expire_date,
                'days_until_expiry' => now()->diffInDays($product->expire_date)
            ]
        );
    }
    
    $this->info('Expiry check completed. ' . $expiringProducts->count() . ' products found.');
}
}
