<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_predictions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained();
        $table->foreignId('store_id')->constrained();
        $table->integer('predicted_quantity');
        $table->decimal('confidence_level', 5, 2); // 0.00 to 1.00
        $table->date('prediction_date');
        $table->date('for_date');
        $table->json('factors'); // Seasonality, trends, etc.
        $table->timestamps();
        
        $table->index(['product_id', 'store_id', 'for_date']);
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_predictions');
    }
};
