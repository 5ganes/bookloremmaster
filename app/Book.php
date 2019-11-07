<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    public function getAuthors(){
    	return $this->belongsToMany('App\Author', 'books_authors_relation', 'bookId', 'authorId');
    }
}
