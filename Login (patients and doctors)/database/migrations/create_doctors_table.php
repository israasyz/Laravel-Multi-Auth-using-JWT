<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(1);
            $table->string('degree');
            $table->string('gender');
            $table->unsignedBigInteger('dep_id')->nullable();
	   //$table->foreign('dep_id')->references('id')->on('departments')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->string('api_token','500');
	    $table->rememberToken();
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
        Schema::dropIfExists('doctors');
    }
}
