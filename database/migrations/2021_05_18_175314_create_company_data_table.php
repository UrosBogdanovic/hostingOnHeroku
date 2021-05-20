<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDataTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('company_data', function (Blueprint $table) {
            $table->id();

            $table->string('username');
            $table->string('password');
            $table->string('company_name');
            $table->string('job_type')->nullable();
            $table->string('phone')->nullable();
            $table->string('domain')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            //$table->unsignedBigInteger('user_id'); //OVO JE SPOLJNI KLJUC KA USERU I TO DEFINISEM ISPOD
            //$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('company_data');
    }

}
