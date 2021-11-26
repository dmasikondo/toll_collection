<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrating_officer');
            $table->foreignId('owner_id');
            $table->string('registration_number')->unique();
            $table->string('make');
            $table->string('slug')->unique();
            $table->string('model');
            $table->year('year');
            $table->string('body_type');
            $table->string('color');
            $table->integer('net_mass');
            $table->integer('gross_mass');
            $table->string('serial_number')->unique();
            $table->string('chasis_number');
            $table->string('engine_capacity');
            $table->string('fuel');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('previous_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id');
            $table->string('country');
            $table->string('reg_no');
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('previous_registrations');
        Schema::dropIfExists('vehicles');
    }
}
