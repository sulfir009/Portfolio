<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name', 32)->nullable();
            $table->unsignedTinyInteger('id_country');
            $table->unsignedInteger('id_business_number');
            $table->unsignedInteger('id_campaign_code');
            $table->unsignedInteger('id_keyword');
            $table->enum('flow', ['psms', 'msisdn_pin', 'he_msisdn_pin', 'msisdn_mo']);

            $table->foreign('id_country')->references('id')->on('countries');
            $table->foreign('id_business_number')->references('id')->on('business_numbers');
            $table->foreign('id_campaign_code')->references('id')->on('campaign_codes');
            $table->foreign('id_keyword')->references('id')->on('keywords');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
