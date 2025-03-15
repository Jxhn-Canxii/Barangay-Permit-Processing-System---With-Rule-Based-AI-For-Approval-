<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('zoning_permits', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_application');
            $table->date('or_date')->nullable();
            $table->string('official_receipt_no')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('address');
            $table->string('zip')->nullable();
            $table->string('owner_name');
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->string('location_of_lot');
            $table->string('right_over_land')->nullable();
            $table->string('lot_area')->nullable();
            $table->integer('status_id')->default(1);
            $table->string('uploaded_file')->nullable(); // Path to uploaded file
            $table->integer('inputted_by')->nullable(); // Path to uploaded file
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('zoning_permits');
    }
};
