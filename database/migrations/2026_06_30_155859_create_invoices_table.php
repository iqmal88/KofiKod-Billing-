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
        Schema::create('invoices', function (Blueprint $table) {

        $table->id();

        $table->foreignId('quotation_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('invoice_no')->unique();

        $table->date('invoice_date');

        $table->date('due_date')->nullable();

        $table->string('payment_stage');

        $table->decimal('payment_percentage',5,2);

        $table->decimal('subtotal',10,2);

        $table->decimal('discount',10,2)->default(0);

        $table->decimal('tax',10,2)->default(0);

        $table->decimal('total',10,2);

        $table->enum('status',[
            'Pending',
            'Paid'
        ])->default('Pending');

        $table->date('payment_date')->nullable();

        $table->string('payment_method')->nullable();

        $table->string('payment_reference')->nullable();

        $table->text('remarks')->nullable();

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
