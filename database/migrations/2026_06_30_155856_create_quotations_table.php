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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();

            $table->string('quotation_no')->unique();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('quotation_date');

            $table->integer('validity_days')->default(30);

            $table->string('project_name');

            $table->longText('project_description');

            $table->date('project_start')->nullable();

            $table->date('project_end')->nullable();

            $table->decimal('subtotal',10,2)->default(0);

            $table->decimal('discount',10,2)->default(0);

            $table->decimal('tax',10,2)->default(0);

            $table->decimal('total',10,2)->default(0);

            $table->enum('status',[
                'Draft',
                'Sent',
                'Accepted',
                'Rejected',
                'Expired'
            ])->default('Draft');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
