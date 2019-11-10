<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksArchiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_archive', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('isbn')->nullable();
            $table->smallInteger('publishedYear');
            $table->smallInteger('publishedMonth')->nullable();
            $table->string('publisher');
            $table->integer('noOfPages');

            $table->string('edition')->nullable();
            $table->string('ddcCallNumber')->nullable();

            $table->string('bookPDF');
            $table->string('image');
            $table->bigInteger('mainBookId')->unsigned();
            $table->timestamps();

            // set foreign key for parent book
            $table->foreign('mainBookId')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books_archive');
    }
}
