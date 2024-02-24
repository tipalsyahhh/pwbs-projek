<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login', function (Blueprint $table) {
            $table->id();
            $table->string('user', 50);
            $table->string('nomor_handphone', 200);
            $table->string('password', 300);
            $table->string('namadepan', 50);
            $table->string('namabelakang', 50);
            $table->timestamps();
            $table->string('remember_token', 100)->nullable();
            $table->string('role', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login');
    }
}
