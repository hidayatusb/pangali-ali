<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('district')->nullable();
            $table->string('regency')->nullable();
            $table->string('province')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('history')->nullable();
            $table->text('description')->nullable();
            $table->decimal('area_km2', 8, 2)->nullable();
            $table->string('lurah_name')->nullable();
            $table->timestamps();
        });

        Schema::create('population_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year')->unique();
            $table->unsignedInteger('total');
            $table->unsignedInteger('male')->default(0);
            $table->unsignedInteger('female')->default(0);
            $table->decimal('growth_percent', 5, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('fishermen', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik')->nullable()->unique();
            $table->unsignedTinyInteger('age');
            $table->string('gender', 20)->default('laki-laki');
            $table->string('address')->nullable();
            $table->string('boat_type')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('fishery_productions', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year')->unique();
            $table->decimal('total_ton', 12, 2);
            $table->decimal('economic_value', 18, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('commodities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('percentage', 5, 2);
            $table->decimal('tonnage', 12, 2)->nullable();
            $table->string('color', 20)->default('#3b82f6');
            $table->unsignedSmallInteger('year');
            $table->timestamps();

            $table->index('year');
        });

        Schema::create('infrastructures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('count')->default(1);
            $table->string('unit')->default('unit');
            $table->string('icon')->nullable();
            $table->string('category')->default('perikanan');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('regional_potentials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::create('welfare_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->string('unit')->nullable();
            $table->unsignedSmallInteger('year');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('year');
        });

        Schema::create('development_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedSmallInteger('year');
            $table->string('status')->default('draft');
            $table->text('description')->nullable();
            $table->decimal('budget', 18, 2)->nullable();
            $table->timestamps();

            $table->index('year');
        });

        Schema::create('map_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('color', 20)->default('#3b82f6');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->json('geojson')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('downloadables', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('downloadables');
        Schema::dropIfExists('news_posts');
        Schema::dropIfExists('map_zones');
        Schema::dropIfExists('development_plans');
        Schema::dropIfExists('welfare_indicators');
        Schema::dropIfExists('regional_potentials');
        Schema::dropIfExists('infrastructures');
        Schema::dropIfExists('commodities');
        Schema::dropIfExists('fishery_productions');
        Schema::dropIfExists('fishermen');
        Schema::dropIfExists('population_stats');
        Schema::dropIfExists('village_profiles');
    }
};
