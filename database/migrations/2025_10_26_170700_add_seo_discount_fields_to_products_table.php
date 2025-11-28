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
        Schema::table('products', function (Blueprint $table) {
            // Pricing / Discount
            $table->decimal('compare_price', 10, 2)->nullable()->after('price');
            $table->enum('discount_type', ['percent', 'fixed'])->nullable()->after('compare_price');
            $table->decimal('discount_value', 10, 2)->nullable()->after('discount_type');
            $table->timestamp('discount_start_at')->nullable()->after('discount_value');
            $table->timestamp('discount_end_at')->nullable()->after('discount_start_at');

            // SEO
            $table->string('seo_title')->nullable()->after('slug');
            $table->string('seo_keywords')->nullable()->after('seo_title');
            $table->text('seo_description')->nullable()->after('seo_keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'compare_price',
                'discount_type',
                'discount_value',
                'discount_start_at',
                'discount_end_at',
                'seo_title',
                'seo_keywords',
                'seo_description',
            ]);
        });
    }
};


