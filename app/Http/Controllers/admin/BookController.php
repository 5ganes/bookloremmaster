<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use Models Model
use App\Book;
use App\Category;
use App\Publisher;
use App\Author;
use App\ArchivedBook;
use App\BookAuthorRelation;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use Auth;
use DB;

class BookController extends Controller
{
    protected $image_path = '';
    protected $pdf_path = '';
    public function __construct(){
        $this->middleware('auth');
        $this->image_path = 'uploads/books/images/';
        $this->pdf_path = 'uploads/books/pdfs/';
    }

    function index(){ // display book list
        // dd(Auth::user()->id);
        if(Auth::user()->type == 'admin'){ 
            $booklist = DB::table('books')
                ->join('users', 'books.userId', '=', 'users.id')
                ->select('books.*', 'users.name as userName')
                ->get();
        }
        else{
            $booklist = Book::where('userId', Auth::user()->id)->get();
        }
        // dd($booklist);
        return view('admin.books.list')
                 ->with(array(
                     'booklist' => $booklist
                 ));
    }

    function addBook(){
    	$bookCatList = Category::where('publish', 1)->get();
        $bookPubList = Publisher::where('publish', 1)->get();
        $authorList = Author::where('publish', 1)->get();
    	return view('admin.books.add')
    				->with(array(
    					'bookCatList' => $bookCatList,
                        'bookPubList' => $bookPubList,
                        'authorList' => $authorList
    				));
    }

    function storebook(Request $request){
        // dd(Input::get('authors'));
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'publishedYear' => 'required',
            // 'publisher' => 'required',
            'noOfPages' => 'required|min:1|numeric',
            'bookCategory' => 'required',
            'bookPublisher' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'bookPDF' => 'required|mimes:pdf|max:102400'
        ]);
        if($v->fails()){
            return redirect::back()->withErrors($v->messages())->withInput();
        }
        else{
            // handle cover image upload
            if($request->hasFile('image')){
                // get filename with the extention
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                // get the filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // get just ext
                $extention = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $imageName = $filename . '_' . time() . '.' . $extention;
                // uppload image
                $path = $request->file('image')->move($this->image_path, $imageName);
            }
            else{
                $imageName = 'noimage.jpg';
            }
            // handle cover image upload ends

            // handle pdf file upload
            if($request->hasFile('bookPDF')){
                // get filename with the extention
                $filenameWithExt = $request->file('bookPDF')->getClientOriginalName();
                // get the filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // get just ext
                $extention = $request->file('bookPDF')->getClientOriginalExtension();
                // Filename to store
                $pdfName = $filename . '_' . time() . '.' . $extention;
                // uppload pdf file
                $path = $request->file('bookPDF')->move($this->pdf_path, $pdfName);
            }
            else{
                $pdfName = 'noimage.jpg';
            }
            // handle cover pdf file upload ends            

            // save book record
            $saveBook = new Book;
            $saveBook->name = Input::get('name');
            $saveBook->isbn = Input::get('isbn');
            $saveBook->publishedYear = Input::get('publishedYear');
            $saveBook->publishedMonth = Input::get('publishedMonth');
            // $saveBook->publisher = Input::get('publisher');
            $saveBook->noOfPages = Input::get('noOfPages');
            $saveBook->edition = Input::get('edition');
            $saveBook->ddcCallNumber = Input::get('ddcCallNumber');
            $saveBook->bookCategory = Input::get('bookCategory');
            $saveBook->bookPublisher = Input::get('bookPublisher');
            $saveBook->bookPDF = $pdfName;
            $saveBook->image = $imageName;
            $saveBook->featured = Input::get('featured');
            $saveBook->publish = Input::get('publish');
            $saveBook->userId = Auth::user()->id;
            $saveBook->save();
            // dd($saveBook->id);
            // save book record ends

            // save data to books_authors_relation table
            $authorIdList = Input::get('authors');
            if($authorIdList != null){
                foreach ($authorIdList as $authorId) {
                    // echo 'BookId : ' . $saveBook->id . ' and Author Id : ' . $authorId . '<br>';
                    $saveBookAuthorRelation = new BookAuthorRelation;
                    $saveBookAuthorRelation->bookId = $saveBook->id;
                    $saveBookAuthorRelation->authorId = $authorId;
                    $saveBookAuthorRelation->save();
                }
                // dd('done');
            }
            // save data to books_authors_relation table ends

            return redirect::to('admin/booklist')->with('success', 'Book Added Successfully.');
        }
    }

    function editBook($id){
        $book = Book::findOrFail($id);
        $oldAuthors = Book::find($id)->getAuthors;
        // dd($oldAuthors);
        $bookCatList = Category::where('publish', 1)->get();
        $bookPubList = Publisher::where('publish', 1)->get();
        $authorList = Author::where('publish', 1)->get();
        return view('admin.books.edit')
                    ->with(array(
                        'book' => $book,
                        'oldAuthors' => $oldAuthors,
                        'bookCatList' => $bookCatList,
                        'bookPubList' => $bookPubList,
                        'authorList' => $authorList
                    ));   
    }

    function updateBook(Request $request, $id){
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'publishedYear' => 'required',
            // 'publisher' => 'required',
            'noOfPages' => 'required|min:1|numeric',
            'bookCategory' => 'required',
            'bookPublisher' => 'required',
            'image' => 'image|nullable|mimes:jpeg,png,jpg|max:2048',
            'bookPDF' => 'nullable|mimes:pdf|max:102400'
        ]);
        if($v->fails()){
            return redirect::back()->withErrors($v->messages())->withInput();
        }
        else{
            $editBook = Book::find($id);

            // handle cover image upload
            if($request->hasFile('image')){
                // delete existing image
                if(File::exists($this->image_path . $editBook->image)){
                    File::delete($this->image_path . $editBook->image);
                }
                // get filename with the extention
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                // get the filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // get just ext
                $extention = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $imageName = $filename . '_' . time() . '.' . $extention;
                // uppload image
                $path = $request->file('image')->move($this->image_path, $imageName);
            }
            else{
                if(!empty($editBook->image) && File::exists($this->image_path . $editBook->image)){
                    $imageName = $editBook->image;
                }
                else $imageName = 'noimage.jpg';
            }
            // handle cover image upload ends

            // handle book pdf upload
            if($request->hasFile('bookPDF')){
                // delete existing pdf
                if(File::exists($this->pdf_path . $editBook->bookPDF)){
                    File::delete($this->pdf_path . $editBook->bookPDF);
                }
                // get filename with the extention
                $filenameWithExt = $request->file('bookPDF')->getClientOriginalName();
                // get the filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // get just ext
                $extention = $request->file('bookPDF')->getClientOriginalExtension();
                // Filename to store
                $pdfName = $filename . '_' . time() . '.' . $extention;
                // uppload pdf file
                $path = $request->file('bookPDF')->move($this->pdf_path, $pdfName);
            }
            else{
                if(!empty($editBook->bookPDF) && File::exists($this->pdf_path . $editBook->bookPDF)){
                    $pdfName = $editBook->bookPDF;
                }
                else $pdfName = 'noimage.jpg';
            }
            // handle book pdf upload ends

            // update book record
            $editBook->name = Input::get('name');
            $editBook->isbn = Input::get('isbn');
            $editBook->publishedYear = Input::get('publishedYear');
            $editBook->publishedMonth = Input::get('publishedMonth');
            // $editBook->publisher = Input::get('publisher');
            $editBook->noOfPages = Input::get('noOfPages');
            $editBook->edition = Input::get('edition');
            $editBook->ddcCallNumber = Input::get('ddcCallNumber');
            $editBook->bookCategory = Input::get('bookCategory');
            $editBook->bookPublisher = Input::get('bookPublisher');
            $editBook->bookPDF = $pdfName;
            $editBook->image = $imageName;
            $editBook->featured = Input::get('featured');
            $editBook->publish = Input::get('publish');
            $editBook->save();
            // update book record ends

            // update data to books_authors_relation table
                $authorIdList = Input::get('authors');
                // dd($authorIdList);

                // delete old but now not selected relations
                if($authorIdList != null){
                    $oldRelation = BookAuthorRelation::where('bookId', $id)->get();
                    if($oldRelation->count() > 0){
                        // dd($oldRelation);
                        foreach ($oldRelation as $relation) {
                            if(in_array($relation->authorId, $authorIdList) == false){
                                BookAuthorRelation::destroy($relation->id);
                            }
                        }
                    }
                }
                // delete old but now not selected relations ends

                if($authorIdList != null){
                    foreach ($authorIdList as $authorId) {
                        $oldAuthorCheck = BookAuthorRelation::where(['authorId' => $authorId, 'bookId' => $id]);
                        if($oldAuthorCheck->count() == 0){
                            $updateBookAuthorRelation = new BookAuthorRelation;
                            $updateBookAuthorRelation->bookId = $id;
                            $updateBookAuthorRelation->authorId = $authorId;
                            $updateBookAuthorRelation->save();
                        }
                    }
                }
            // update data to books_authors_relation table ends

            return redirect::to('admin/booklist')->with('success', 'Book Updated Successfully.');

        }
    }

    function deleteBook($id){
        try{
            $archivedBooksUnderThisBook = ArchivedBook::where('mainBookId', $id)->get();
            // dd(count($archivedBooksUnderThisBook));
            if(count($archivedBooksUnderThisBook) == 0){
                $book = Book::find($id);
                if(File::exists($this->image_path . $book->image)){
                        File::delete($this->image_path . $book->image);
                }
                if(File::exists($this->pdf_path . $book->bookPDF)){
                        File::delete($this->pdf_path . $book->bookPDF);
                }
                Book::destroy($id);
            }
            else{
                return redirect::back()->with('warning', 'Book can not be Deleted. There are Archived Books under it.');
            }
        } catch(\Exception $e){
            return redirect::back()
                ->with('errors','Can Not be Deleted');

        }
        return redirect::to('admin/booklist')->with('success', 'Book Deleted Successfully.');
    }

    function deleteBookCoverImageAjax(Request $request){
        $book = Book::findOrFail($request->id);
        if(File::exists($this->image_path . $book->image)){
            File::delete($this->image_path . $book->image);
            $book->image = 'noimage.jpg';
            $book->save();
            echo true;
        }
        else{
            echo false;
        }
    }

}



