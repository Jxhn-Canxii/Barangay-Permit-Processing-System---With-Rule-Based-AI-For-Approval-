<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('zoning_permits', function (Blueprint $table) {
            $table->id();
            // Existing fields
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
            
            // Enhanced zoning-specific fields
            $table->integer('location_of_lot');
            $table->integer('zoning_district');
            $table->integer('right_over_land');
            $table->decimal('lot_area', 10, 2)->nullable(); // Changed to decimal
            $table->integer('proposed_use'); // Added
            $table->integer('existing_structures')->default(0); // Added
            $table->boolean('setback_compliance')->default(false); // Added
            
            // Status and tracking
            $table->integer('status_id')->default(1);
            $table->string('uploaded_file')->nullable();
            $table->integer('inputted_by')->nullable();
            $table->timestamps();

            // Indexes for faster queries
            $table->index('status_id');
            $table->index('zoning_district');
        });
    }

    public function down() {
        Schema::dropIfExists('zoning_permits');
    }
};