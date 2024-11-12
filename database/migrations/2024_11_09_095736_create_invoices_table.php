<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('subtotal', 8, 2); 
            $table->decimal('tax_percentage', 5, 2)->nullable(); 
            $table->decimal('tax', 8, 2)->nullable(); 
            $table->decimal('discount_percentage', 5, 2)->nullable(); 
            $table->decimal('discount', 8, 2)->nullable();           
            $table->decimal('total_amount', 8, 2); 
            $table->string('payment_method');
            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
