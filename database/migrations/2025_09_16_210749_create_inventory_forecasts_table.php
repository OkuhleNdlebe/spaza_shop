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
       Schema::create('inventory_forecasts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained();
        $table->foreignId('store_id')->constrained();
        $table->integer('current_stock');
        $table->integer('predicted_demand');
        $table->integer('recommended_order');
        $table->date('stockout_risk_date')->nullable();
        $table->decimal('stockout_probability', 5, 2);
        $table->date('forecast_date');
        $table->date('for_date');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_forecasts');
    }
};
