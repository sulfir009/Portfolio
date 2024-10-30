<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('main', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('hash', 32);
            $table->string('campaigns_key_binom', 32);
            $table->unsignedInteger('aff_company_id');
            $table->unsignedInteger('pid');
            $table->string('partner_id', 128)->nullable();
            $table->string('password', 62)->nullable();
            $table->unsignedInteger('id_services');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_services')->references('id')->on('services');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('main');
    }
};
