<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('invoice_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Item Source
            |--------------------------------------------------------------------------
            |
            | payment_phase
            | change_request
            |
            */

            $table->enum('item_type', [
                'payment_phase',
                'change_request'
            ]);

            /*
            |--------------------------------------------------------------------------
            | References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('payment_term_id')
                ->nullable()
                ->constrained('payment_terms')
                ->nullOnDelete();

            $table->foreignId('change_request_id')
                ->nullable()
                ->constrained('change_requests')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Invoice Snapshot
            |--------------------------------------------------------------------------
            */

            $table->string('title');

            $table->text('description')->nullable();

            $table->decimal('percentage', 5, 2)->nullable();

            $table->decimal('amount', 10, 2);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};