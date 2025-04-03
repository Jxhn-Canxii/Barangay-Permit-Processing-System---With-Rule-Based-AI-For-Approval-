<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidentsTable extends Migration
{
    public function up()
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->date('dateofcencus');
            $table->string('areaofcencusstreet');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->date('birthday');
            $table->integer('age');
            $table->string('gender');
            $table->string('civilstatus');
            $table->string('currentschoolenrollment');
            $table->string('educationalattainment');
            $table->string('employmentstatus');
            $table->string('occupation');
            $table->integer('housenumber');
            $table->string('streetname');
            $table->string('barangay');
            $table->string('city');
            $table->string('province');
            $table->string('housetype');
            $table->string('healthstatus');
            $table->string('disabilitystatus');
            $table->string('existinghealthcondition')->nullable();
            $table->string('fullyimmunized');
            $table->string('covid19vaccination');
            $table->string('housingtype');
            $table->integer('yearofconstructed');
            $table->string('residentlived');
            $table->string('mobilenumber');
            $table->string('emergencycontactname');
            $table->string('emergencycontactnumber');
            $table->string('relationshiptoemergencycontact');
            $table->integer('numberofhousemembers');
            $table->json('householdMembers')->nullable();  // Assuming household members might be an array of objects or JSON
            $table->timestamps();  // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('residents');
    }
}
