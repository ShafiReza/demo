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
       Schema::create('client', function (Blueprint $table) {
           $table->id();
           $table->string('client_name')->nullable();
           $table->foreignId('provider_id')->constrained()->cascadeOnDelete();
           $table->string('type')->nullable();
           $table->string('commission_rate')->nullable();
           $table->decimal('opening_balance', 15, 2)->default(0);
           $table->decimal('receive', 15, 2)->default(0);
           $table->decimal('sales', 15, 2)->default(0);
           $table->decimal('total_balance', 15, 2)->default(0);
           $table->text('note')->nullable();
           $table->boolean('active')->default(true);
           $table->timestamps();
       });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
       Schema::dropIfExists('client');
   }
};
