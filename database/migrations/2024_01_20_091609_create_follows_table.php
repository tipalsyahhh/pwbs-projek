<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('following_user_id');
            $table->string('notifikasi', 30)->nullable();
            $table->timestamps();

            // Tambahkan foreign keys
            $table->foreign('user_id')->references('id')->on('login')->onDelete('cascade');
            $table->foreign('following_user_id')->references('id')->on('login')->onDelete('cascade');

            // Tambahkan indeks
            $table->index('user_id');
            $table->index('following_user_id');
        });
    }

    /**
     * Rollback migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}

