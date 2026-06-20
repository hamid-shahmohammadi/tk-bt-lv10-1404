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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_msg_id'); 
            $table->foreign('user_msg_id')->references('id')->on('users');            

            $table->unsignedBigInteger('customer_msg_id'); 
            $table->foreign('customer_msg_id')->references('id')->on('customers');                       

            $table->text('msg');
            $table->boolean('user_to_customer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
