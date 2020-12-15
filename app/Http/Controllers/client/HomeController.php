<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Publisher;
use App\Book;
use App\archivedBook;

class HomeController extends Controller
{
	protected $categoryList = '';
    public function __construct(){
    	$this->categoryList = Category::where('publish', 1)->get();
    }

    public function index(){
    	$featuredBooks = Book::where('publish', 1)->where('featured', 1)->get();
    	return view('client.home')->with(array(
    		'categoryList' => $this->categoryList,
    		'featuredBooks' => $featuredBooks
    	));
	}

	public function getBooksByCategory($id){
		$categoryName = Category::find($id)->name;
		$books = Book::where('bookCategory', $id)->where('publish', 1)->get();
		return view('client.booksbycategory')->with(array(
			'categoryList' => $this->categoryList,
			'categoryName' => $categoryName,
			'books' => $books
		));
	}

	public function getSingleBook($id){
		$book = Book::findOrFail($id);
		// dd($book);
		$category = Category::find($book->bookCategory);
		$publisher = Publisher::find($book->bookPublisher);
		$otherBooksOfCategory = Book::where('bookCategory', $book->bookCategory)->where('id', '!=', $id)->where('publish', 1)->get();
		
		$authors = Book::find($id)->getAuthors;
		// $authorsArray = array();
		// foreach ($authors as $author) {
		// 	array_push($authorsArray, $author->name);
		// }
		// $arrayNamesList = implode(', ', $authorsArray);
		return view('client.singlebook')->with(array(
			'categoryList' => $this->categoryList,
			'category' => $category,
			'publisher' => $publisher,
			'book' => $book,
			'otherBooksOfCategory' => $otherBooksOfCategory,
			'authors' => $authors
		)); 
	}

	function archivedBooks($mainBookId){
		$mainBook = Book::findOrFail($mainBookId);
		$archivedBooks = archivedBook::where('mainBookId', $mainBookId)->orderBy('publishedYear', 'DESC')->get();
		$authors = Book::find($mainBookId)->getAuthors;
		$categoryName = Category::find($mainBook->bookCategory)->name;
		return view('client.archivedbooklist')->with(array(
			'categoryList' => $this->categoryList,
			'archivedBooks' => $archivedBooks,
			'authors' => $authors,
			'mainBook' => $mainBook,
			'categoryName' => $categoryName
		));
	}

	public function getSingleArchivedBook($id){
		$mainBookId = ArchivedBook::where('id', $id)->get()->first()->mainBookId;
		$mainBook = Book::findOrFail($mainBookId);
		$archivedBook = ArchivedBook::findOrFail($id);
		$category = Category::find($mainBook->bookCategory);
		$publisher = Publisher::find($mainBook->bookPublisher);
		$otherArchivedBooksOfBook = ArchivedBook::where('mainBookId', $archivedBook->mainBookId)->where('id', '!=', $id)->get();
		
		$authors = Book::find($mainBookId)->getAuthors;
		return view('client.archivedbooksingle')->with(array(
			'categoryList' => $this->categoryList,
			'mainBook' => $mainBook,
			'category' => $category,
			'publisher' => $publisher,
			'archivedBook' => $archivedBook,
			'otherArchivedBooksOfBook' => $otherArchivedBooksOfBook,
			'authors' => $authors
		)); 
	}

}





