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
        Schema::create('depends', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('family',64);
            $table->string('father',32)->nullable();
            $table->enum('sex', ['m', 'f']);
            $table->string('national_code',32)->unique();
            $table->string('birth_certificate',32)->nullable();
            $table->string('birth_date',10);
            $table->string('mobile',32)->nullable();
            $table->string('phone',32)->nullable();

            $table->bigInteger('user_id')->nullable()->unsigned();

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->bigInteger('relation_id')->nullable()->unsigned();
            $table->string('start_activity',10)->nullable();
            $table->string('end_activity',10)->nullable();

            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depends');
    }
};
