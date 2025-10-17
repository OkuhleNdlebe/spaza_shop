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
// database/migrations/xxxx_create_reports_table.php
public function up()
{
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('type'); // 'sales', 'inventory', 'expiry', 'performance'
        $table->json('parameters'); // Store report filters as JSON
        $table->text('description')->nullable();
        $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('reports');
    }
};
