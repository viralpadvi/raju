<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('gst_rate', 5, 2)->default(0)->after('tax_amount');
            $table->decimal('gst_amount', 10, 2)->default(0)->after('gst_rate');
            $table->string('gst_number')->nullable()->after('gst_amount');
            $table->string('invoice_number')->unique()->nullable()->after('sale_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['gst_rate', 'gst_amount', 'gst_number', 'invoice_number']);
        });
    }
};
