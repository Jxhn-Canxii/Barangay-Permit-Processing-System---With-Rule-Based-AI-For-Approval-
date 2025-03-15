<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(); // Name of the user performing the action
            $table->string('action'); // Description of the action
            $table->string('module')->nullable(); 
            $table->string('ip_address')->nullable(); // User's IP address
            $table->text('details')->nullable(); // Extra details if needed
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('logs');
    }
};
