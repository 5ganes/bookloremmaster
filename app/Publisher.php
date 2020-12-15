<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    
	protected $table = 'book_publishers';

    public function getBooks(){
    	return $this->hasMany('App\Book', 'bookPublisher');
    }

}
