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
        Schema::create('expiry_alerts', function (Blueprint $table) {
         $table->id();
        $table->foreignId('product_id')->constrained();
        $table->foreignId('store_id')->constrained();
        $table->date('expiry_date');
        $table->integer('days_until_expiry');
        $table->boolean('notification_sent')->default(false);
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
        Schema::dropIfExists('expiry_alerts');
    }
};
