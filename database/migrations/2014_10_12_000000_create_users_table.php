<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('names');
            $table->enum('sex',['male','female']);
            $table->string('national_id')->unique();
            $table->string('slug')->unique();            
            $table->string('email')->unique();
            $table->string('cellphone_no')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->unsignedBigInteger('suspender_id')->nullable();            
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
