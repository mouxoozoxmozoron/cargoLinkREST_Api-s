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
        Schema::create('transportation_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_id');
            $table->string('contact');
            $table->string('email');
            $table->string('bank_acount_number');
            $table->string('bank_type');
            $table->string('agent_logo');
            $table->string('location');
            $table->string('company_category');
            $table->string('working_day');
            $table->string('routes');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportation_companies');
    }
};
