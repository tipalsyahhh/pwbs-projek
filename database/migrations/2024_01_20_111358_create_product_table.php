<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('alamat_id')->nullable();
            $table->unsignedBigInteger('jumlah_beli')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('is_new')->nullable();
            $table->unsignedBigInteger('total_harga')->nullable();
            $table->string('status', 20)->nullable();
            $table->string('notifikasi', 30)->nullable();

            // Add foreign keys
            $table->foreign('menu_id')->references('id')->on('postingan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('login')->onDelete('cascade');
            $table->foreign('alamat_id')->references('id')->on('profile')->onDelete('cascade');

            // Add indexes
            $table->index('menu_id');
            $table->index('user_id');
            $table->index('alamat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
