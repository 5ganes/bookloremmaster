<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ArchivedBook;
use App\Book;
use App\Author;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Auth;
use DB;

class BookArchiveController extends Controller
{
    protected $image_path = '';
    protected $pdf_path = '';
    public function __construct(){
        $this->middleware('auth');
        $this->image_path = 'uploads/books/images/';
        $this->pdf_path = 'uploads/books/pdfs/';
    }

	function index($mainBookId){
        $booklist = ArchivedBook::where('mainBookId', $mainBookId)->orderBy('publishedYear', 'DESC')->get();
        $mainBook = Book::find($mainBookId);
		return view('admin.archivedbooks.list')
                 ->with(array(
                     'booklist' => $booklist,
                     'mainBook' => $mainBook
                 ));
	}

	function addArchivedBook($mainBookId){
		$currentPublishedYear = Book::where('id', $mainBookId)->get()->first()->publishedYear;
		// dd($mainBookId . ' , ' . $currentPublishedYear->publishedYear);
		$mainBook = DB::table('books')
						->join('book_categories', 'books.bookCategory', '=', 'book_categories.id')
                        ->join('book_publishers', 'books.bookPublisher', '=', 'book_publishers.id')
						->select('books.*', 'book_categories.name as categoryName', 'book_publishers.name as publisherName')
						->where('books.id', $mainBookId)
						->get()->first();
		$authors = Book::find($mainBookId)->getAuthors;
		return view('admin.archivedbooks.add')
    				->with(array(
                        'currentPublishedYear' => $currentPublishedYear,
                        'mainBook' => $mainBook,
                        'authors' => $authors
    				));

	}

	function storeArchivedBook(Request $request, $mainBookId){
		$v = Validator::make($request->all(), [
            'publishedYear' => 'required|unique:books_archive,publishedYear',
            // 'publisher' => 'required',
            'noOfPages' => 'required|min:1|numeric',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'bookPDF' => 'required|mimes:pdf|max:102400'
		]);
		if($v->fails()){
			return redirect::back()->withErrors($v->messages())->withInput();
		}
		else{

			// handle cover image upload
            if($request->hasFile('image')){
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extention = $request->file('image')->getClientOriginalExtension();
                $imageName = $filename . '_' . time() . '.' . $extention;
                $path = $request->file('image')->move($this->image_path, $imageName);
            }
            else{
                $imageName = 'noimage.jpg';
        	}
            // handle cover image upload ends

            // handle pdf file upload
            if($request->hasFile('bookPDF')){
                $filenameWithExt = $request->file('bookPDF')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extention = $request->file('bookPDF')->getClientOriginalExtension();
                $pdfName = $filename . '_' . time() . '.' . $extention;
                $path = $request->file('bookPDF')->move($this->pdf_path, $pdfName);
            }
            else{
                $pdfName = 'noimage.jpg';
            }
            // handle cover pdf file upload ends

			// save archived book record
            $saveArchivedBook = new ArchivedBook;
            $saveArchivedBook->isbn = Input::get('isbn');
            $saveArchivedBook->publishedYear = Input::get('publishedYear');
            $saveArchivedBook->publishedMonth = Input::get('publishedMonth');
            // $saveArchivedBook->publisher = Input::get('publisher');
            $saveArchivedBook->noOfPages = Input::get('noOfPages');

            $saveArchivedBook->edition = Input::get('edition');
            $saveArchivedBook->ddcCallNumber = Input::get('ddcCallNumber');

            $saveArchivedBook->bookPDF = $pdfName;
            $saveArchivedBook->image = $imageName;
            $saveArchivedBook->mainBookId = $mainBookId;
            $saveArchivedBook->save();
            // save archived book record ends
            return redirect::to('admin/archivedbooklist/' . $mainBookId)->with('success', 'Archived Book Added Successfully.');

		}
	}

	function editArchivedBook($id){
		$mainBookId = ArchivedBook::where('id', $id)->get()->first()->mainBookId;
		$currentPublishedYear = Book::where('id', $mainBookId)->get()->first()->publishedYear;

		$mainBook = DB::table('books')
						->join('book_categories', 'books.bookCategory', '=', 'book_categories.id')
                        ->join('book_publishers', 'books.bookPublisher', '=', 'book_publishers.id')
						->select('books.*', 'book_categories.name as categoryName', 'book_publishers.name as publisherName')
						->where('books.id', $mainBookId)
						->get()->first();
		$archivedBook = ArchivedBook::findOrFail($id);
		$authors = Book::find($mainBookId)->getAuthors;
		return view('admin.archivedbooks.edit')
    				->with(array(
    					'archivedBook' => $archivedBook,
                        'currentPublishedYear' => $currentPublishedYear,
                        'mainBook' => $mainBook,
                        'authors' => $authors
    				));
	}

	function updateArchivedBook(Request $request, $id){
		// unique:book_categories,name,'.$category->id
		$mainBookId = ArchivedBook::where('id', $id)->get()->first()->mainBookId;
		$v = Validator::make($request->all(), [
            'publishedYear' => 'required|unique:books_archive,publishedYear,'.$id,
            // 'publisher' => 'required',
            'noOfPages' => 'required|min:1|numeric',
            'image' => 'image|nullable|mimes:jpeg,png,jpg|max:2048',
            'bookPDF' => 'nullable|mimes:pdf|max:102400'
		]);
		if($v->fails()){
			return redirect::back()->withErrors($v->messages())->withInput();
		}
		else{
			$editArchivedBook = ArchivedBook::find($id);
			// handle cover image upload
            if($request->hasFile('image')){
                if(File::exists($this->image_path . $editArchivedBook->image)){
                    File::delete($this->image_path . $editArchivedBook->image);
                }
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extention = $request->file('image')->getClientOriginalExtension();
                $imageName = $filename . '_' . time() . '.' . $extention;
                $path = $request->file('image')->move($this->image_path, $imageName);
            }
            else{
                if(!empty($editArchivedBook->image) && File::exists($this->image_path . $editArchivedBook->image)){
                    $imageName = $editArchivedBook->image;
                }
                else $imageName = 'noimage.jpg';
            }
            // handle cover image upload ends

            // handle book pdf upload
            if($request->hasFile('bookPDF')){
                if(File::exists($this->pdf_path . $editArchivedBook->bookPDF)){
                    File::delete($this->pdf_path . $editArchivedBook->bookPDF);
                }
                $filenameWithExt = $request->file('bookPDF')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extention = $request->file('bookPDF')->getClientOriginalExtension();
                $pdfName = $filename . '_' . time() . '.' . $extention;
                $path = $request->file('bookPDF')->move($this->pdf_path, $pdfName);
            }
            else{
                if(!empty($editArchivedBook->bookPDF) && File::exists($this->pdf_path . $editArchivedBook->bookPDF)){
                    $pdfName = $editArchivedBook->bookPDF;
                }
                else $pdfName = 'noimage.jpg';
            }
            // handle book pdf upload ends

			// update archived book record
            $editArchivedBook->isbn = Input::get('isbn');
            $editArchivedBook->publishedYear = Input::get('publishedYear');
            $editArchivedBook->publishedMonth = Input::get('publishedMonth');
            // $editArchivedBook->publisher = Input::get('publisher');
            $editArchivedBook->noOfPages = Input::get('noOfPages');

            $editArchivedBook->edition = Input::get('edition');
            $editArchivedBook->ddcCallNumber = Input::get('ddcCallNumber');

            $editArchivedBook->bookPDF = $pdfName;
            $editArchivedBook->image = $imageName;
            $editArchivedBook->save();
            // update archived book record ends

            return redirect::to('admin/archivedbooklist/' . $mainBookId)->with('success', 'Archived Book Updated Successfully.');

		}

	}

    function deleteArchivedBook($id){
        $mainBookId = ArchivedBook::where('id', $id)->get()->first()->mainBookId;
        try{
            $archivedBook = ArchivedBook::find($id);
            if(File::exists($this->image_path . $archivedBook->image)){
                    File::delete($this->image_path . $archivedBook->image);
            }
            if(File::exists($this->pdf_path . $archivedBook->bookPDF)){
                    File::delete($this->pdf_path . $archivedBook->bookPDF);
            }
            ArchivedBook::destroy($id);
        } catch(\Exception $e){
            return redirect::back()
                ->with('errors','Can Not be Deleted');

        }
        return redirect::to('admin/archivedbooklist/' . $mainBookId)->with('success', 'Archived Book Deleted Successfully.');
    }

	function deleteArchivedBookCoverImageAjax(Request $request){
		$archivedBook = ArchivedBook::findOrFail($request->id);
        if(File::exists($this->image_path . $archivedBook->image)){
            File::delete($this->image_path . $archivedBook->image);
            $archivedBook->image = 'noimage.jpg';
            $archivedBook->save();
            echo true;
        }
        else{
            echo false;
        }
	}

}







