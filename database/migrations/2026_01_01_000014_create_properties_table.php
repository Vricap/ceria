<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('property_type_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('province_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('area_id')->nullable()->constrained()->nullOnDelete();

            // Basic Info
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('property_id_code')->nullable(); // PROP-001
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();

            // Transaction
            $table->enum('transaction_type', ['dijual', 'disewa'])->default('dijual');
            $table->decimal('price', 20, 2)->nullable();
            $table->decimal('price_rent_monthly', 20, 2)->nullable();
            $table->string('price_note')->nullable(); // negotiable, etc

            // Specs
            $table->decimal('land_area', 10, 2)->nullable(); // m²
            $table->decimal('building_area', 10, 2)->nullable(); // m²
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('garage')->nullable();
            $table->integer('floors')->nullable();
            $table->string('certificate')->nullable(); // SHM, HGB, etc
            $table->integer('year_built')->nullable();
            $table->string('electric_power')->nullable(); // 1300W, etc

            // Location
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Media
            $table->string('thumbnail')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();

            // Status & Visibility
            $table->enum('status', ['draft', 'pending', 'published', 'featured', 'sold', 'rented', 'expired', 'archived', 'rejected'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'transaction_type']);
            $table->index(['city_id', 'status']);
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
