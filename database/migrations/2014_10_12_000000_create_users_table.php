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
            $table->string('username')->min(10)->max(20);
            $table->string('email')->unique()->min(20)->max(50);//->mail()
            $table->string('password')->min(5)->max(20);
            $table->string('nama')->max(50);
            $table->string('nomor_telepon')->max(12)->is_numeric();
            $table->integer('role')->max(1);
            $table->integer('status')->max(1);
            // $table->string('ktp')->nullable()->max(16);
            $table->string('tentang_user')->nullable();
            // $table->rememberToken();
            // $table->timestamps();
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
