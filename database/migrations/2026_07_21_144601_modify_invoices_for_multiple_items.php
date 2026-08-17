<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {

            $table->string('payment_stage')
                ->nullable()
                ->change();

            $table->integer('payment_percentage')
                ->nullable()
                ->change();

        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {

            $table->string('payment_stage')
                ->nullable(false)
                ->change();

            $table->integer('payment_percentage')
                ->nullable(false)
                ->change();

        });
    }
};