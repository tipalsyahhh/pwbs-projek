<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('like')->nullable();
            $table->unsignedBigInteger('like')->nullable(); 
            $table->text('comentar')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('notifikasi', 255)->nullable();

            // Add foreign keys
            $table->foreign('user_id')->references('id')->on('login')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');

            // Add indexes
            $table->index('user_id');
            $table->index('status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
