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
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vacation_user_id');
            $table->date('vacation_date');
            $table->time('vacation_start');
            $table->time('vacation_end');
            $table->string('vacation_why');
            $table->string('is_verified');
            $table->unsignedBigInteger('vacation_verifier_id')->nullable();
            $table->timestamps();

            $table->foreign('vacation_user_id')->references('id')->on('users');
            $table->foreign('vacation_verifier_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacations');
    }
};
