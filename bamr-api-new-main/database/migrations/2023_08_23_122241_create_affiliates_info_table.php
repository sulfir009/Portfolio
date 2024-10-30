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
        Schema::create('affiliates_info', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('id_affiliates');
            $table->unsignedTinyInteger('id_country')->nullable();
            $table->string('postback_url');
            $table->timestamps();

            $table->foreign('id_country')->references('id')->on('countries');
            $table->foreign('id_affiliates')->references('id')->on('affiliates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliates_info');
    }
};
