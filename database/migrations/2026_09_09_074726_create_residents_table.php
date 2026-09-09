<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('occupation');
            $table->string('gender', 20);
            $table->string('phone', 50)->nullable();
            $table->string('marital_status', 50);
            $table->string('religion', 50);
            $table->timestamps();

            $table->index('name');
            $table->index('gender');
            $table->index('occupation');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
