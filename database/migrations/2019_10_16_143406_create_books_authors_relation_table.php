<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksAuthorsRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_authors_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bookId')->unsigned();
            $table->bigInteger('authorId')->unsigned();
            $table->timestamps();

            // add foreign keys
            $table->foreign('bookId')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('authorId')->references('id')->on('authors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books_authors_relation');
    }
}
