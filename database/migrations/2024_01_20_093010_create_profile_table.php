<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('nama_depan', 30);
            $table->string('nama_belakang', 30);
            $table->date('tanggal_lahir');
            $table->string('alamat', 50);
            $table->string('gender', 50);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('biodata')->nullable();
            $table->timestamps();

            // Add foreign keys
            $table->foreign('user_id')->references('id')->on('login')->onDelete('cascade');

            // Add indexes
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile');
    }
}
