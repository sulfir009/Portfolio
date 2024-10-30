<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_main');
            $table->string('binom_click_id', 32);
            $table->string('affise_click_id', 32)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('operator', 32)->nullable();
            $table->string('aff_click_id', 32)->nullable();
            $table->unsignedInteger('aff_id')->nullable();
            $table->string('subid1', 32)->nullable();
            $table->string('subid2', 32)->nullable();
            $table->string('subid3', 32)->nullable();
            $table->string('subid4', 32)->nullable();
            $table->string('subid5', 32)->nullable();
            $table->string('external', 36)->nullable();
            $table->boolean('is_charged')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->nullable();
            $table->foreign('id_main')->references('id')->on('main');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};
