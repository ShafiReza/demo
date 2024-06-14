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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name')->nullable();
            $table->string('provider_type')->nullable();
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('receive', 15, 2)->default(0);
            $table->decimal('total_balance', 15, 2)->default(0);
            $table->text('note')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
