<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('caption')->nullable();
            $table->string('image', 500)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('comentar_id')->nullable();
            $table->unsignedBigInteger('like')->nullable();

            // Add foreign keys
            $table->foreign('user_id')->references('id')->on('login')->onDelete('cascade');

            // Add indexes
            $table->index('user_id');
            $table->index('like');
            $table->index('comentar_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status');
    }
}
