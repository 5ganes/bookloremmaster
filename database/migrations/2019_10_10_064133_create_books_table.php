<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('isbn')->nullable();
            $table->smallInteger('publishedYear');
            $table->smallInteger('publishedMonth')->nullable();
            // $table->string('publisher');
            $table->integer('noOfPages');
            $table->string('edition')->nullable();
            $table->string('ddcCallNumber')->nullable();
            // $table->bigInteger('authorId')->unsigned();
            $table->bigInteger('bookCategory')->unsigned();
            $table->bigInteger('bookPublisher')->unsigned();
            $table->string('bookPDF');
            $table->string('image');
            $table->string('keywords');
            $table->integer('featured')->unsigned();
            $table->integer('publish')->unsigned();
            $table->bigInteger('userId')->unsigned();
            $table->timestamps();

            // set foreign key
            // $table->foreign('bookCategory')->references('id')->on('book_categories')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('bookPublisher')->references('id')->on('book_publishers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bookCategory')->references('id')->on('book_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bookPublisher')->references('id')->on('book_publishers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
