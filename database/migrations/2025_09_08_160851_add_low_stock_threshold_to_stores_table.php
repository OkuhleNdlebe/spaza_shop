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
        Schema::table('stores', function (Blueprint $table) {
            // Check if column doesn't exist before adding (prevents errors)
            if (!Schema::hasColumn('stores', 'low_stock_threshold')) {
                $table->integer('low_stock_threshold')->default(5)->after('contact_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            // FIXED: Actually drop the column when rolling back
            if (Schema::hasColumn('stores', 'low_stock_threshold')) {
                $table->dropColumn('low_stock_threshold');
            }
        });
    }
};