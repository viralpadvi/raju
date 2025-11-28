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
        Schema::create('ad_placements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('location', ['home', 'category', 'product', 'checkout'])->default('home');
            $table->enum('position', ['top', 'middle', 'bottom', 'sidebar'])->default('top');
            $table->string('size')->default('728x90');
            $table->unsignedBigInteger('campaign_id');
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->decimal('ctr', 5, 2)->default(0);
            $table->enum('status', ['active', 'inactive', 'scheduled'])->default('active');
            $table->timestamps();
            
            $table->foreign('campaign_id')->references('id')->on('ad_campaigns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_placements');
    }
};