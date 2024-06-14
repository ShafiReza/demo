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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_provider');
            $table->unsignedBigInteger('to_provider');
            $table->decimal('transfer_amount', 10, 2);
            $table->text('note')->nullable();
            $table->timestamps();

            // Define foreign key constraints with cascading deletes
            $table->foreign('from_provider')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('to_provider')->references('id')->on('providers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['from_provider']);
            $table->dropForeign(['to_provider']);
        });

        Schema::dropIfExists('transfers');
    }
};

