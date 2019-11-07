<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'book_categories';

    public function getBooks(){
    	return $this->hasMany('App\Book', 'bookCategory');
    }
}
