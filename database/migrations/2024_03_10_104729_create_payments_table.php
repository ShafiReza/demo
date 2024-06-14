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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreignId('provider_id')->nullable()->constrained()->onDelete('set null'); // Ensure provider_id column exists
            $table->double('amount');
            $table->string('description')->nullable();
            $table->enum('type', ['credit', 'sales']);
            $table->double('updated_balance')->nullable();
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('client_id')->references('id')->on('client')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
