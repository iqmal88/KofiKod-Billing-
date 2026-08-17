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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();

            $table->string('company_name');

            $table->string('company_tagline')->nullable();

            $table->string('logo')->nullable();

            $table->string('phone')->nullable();

            $table->string('email')->nullable();

            $table->string('website')->nullable();

            $table->text('address')->nullable();

            $table->string('bank_name')->nullable();

            $table->string('bank_account')->nullable();

            $table->string('bank_holder')->nullable();

            $table->string('signature')->nullable();

            $table->longText('terms_conditions')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
