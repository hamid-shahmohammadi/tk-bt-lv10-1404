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
        Schema::create('contract_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id'); 
            $table->foreign('contract_id')->references('id')->on('contracts');

            $table->unsignedBigInteger('harm_type_id'); 
            $table->foreign('harm_type_id')->references('id')->on('harm_types');
            
            $table->bigInteger('cost');
            $table->integer('repeat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_details');
    }
};
