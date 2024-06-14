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
        Schema::create('sale_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('day_start');
            $table->double('server_sales')->nullable();
            $table->string('day_end')->nullable();
            $table->boolean('finalized')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_tracking');
    }
};
