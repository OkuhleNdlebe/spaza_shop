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
    Schema::table('products', function (Blueprint $table) {
        $table->text('qr_code')->nullable(); // Add the qr_code column
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('qr_code');
    });
}

};
