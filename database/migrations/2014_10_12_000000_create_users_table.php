<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void    'ime',
        'prezime',
        'username',
        'broj_telefona',
        'datum_rodjenja',
        //'email',
        'password',
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('phone_number')->nullable();
            $table->dateTime('birth_date')->nullable();
            $table->string('picture_url')->nullable();
            //$table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
           // $table->string('password');
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
        Schema::dropIfExists('users');
    }
}
