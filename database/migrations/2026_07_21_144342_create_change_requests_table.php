<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('change_requests', function (Blueprint $table) {

            $table->id();

            $table->foreignId('quotation_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('change_request_no')
                ->unique();

            $table->date('request_date');

            $table->string('title');

            $table->text('description')->nullable();

            $table->decimal('total', 10, 2)
                ->default(0);

            $table->enum('status', [
                'Draft',
                'Pending Approval',
                'Approved',
                'Rejected'
            ])->default('Draft');

            $table->date('approved_date')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('change_requests');
    }
};