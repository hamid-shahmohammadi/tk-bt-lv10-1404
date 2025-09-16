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
        Schema::create('harms', function (Blueprint $table) {
            $table->id();
            $table->string('billing_date',10)->nullable();
            $table->integer('billing_time')->nullable();
            $table->string('description',128)->nullable();
            $table->integer('cost');
            $table->integer('cost_submit')->nullable();
            $table->bigInteger('harm_type_id')->nullable()->unsigned();
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->bigInteger('payment_status_id')->nullable()->unsigned();

            $table->unsignedBigInteger('customer_id'); 
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->bigInteger('depend_id')->nullable()->unsigned();
            $table->bigInteger('contract_id')->nullable()->unsigned();

            $table->boolean('doctor_approval')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harms');
    }
};
