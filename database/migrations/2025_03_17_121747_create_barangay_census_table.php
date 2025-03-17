<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('barangay_census', function (Blueprint $table) {
            $table->id();
            $table->integer('year'); // Year of census
            $table->integer('population'); // Total population
            $table->integer('households'); // Number of households
            $table->integer('male'); // Male population
            $table->integer('female'); // Female population
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangay_census');
    }
};
