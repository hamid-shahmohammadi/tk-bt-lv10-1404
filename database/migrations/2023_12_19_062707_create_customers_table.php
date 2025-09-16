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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('family',64);
            $table->string('father',16)->nullable();
            $table->string('email',64)->nullable();
            $table->string('username',64);
            $table->string('personnel_code',16)->nullable();
            $table->string('national_code',32)->unique();
            $table->string('birth_certificate',32)->nullable();
            $table->string('birth_date',10)->nullable();
            $table->bigInteger('organization_id')->nullable()->unsigned();
            $table->bigInteger('contract_id')->nullable()->unsigned();
            $table->string('password',128);
            $table->string('mobile',32)->nullable();
            $table->string('phone',32)->nullable();
            $table->string('sheba',32)->nullable();
            $table->string('account_number',32)->nullable();
            $table->string('booklet_number',32)->nullable();
            $table->enum('sex', ['m', 'f'])->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('customers');
    }
};
