<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use Author Model
use App\Author;
use App\BookAuthorRelation;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use Auth;

class AuthorController extends Controller
{
    protected $image_path = '';
    public function __construct(){
        $this->middleware('auth');
        $this->image_path = 'uploads/authors/';
    }

    function index(){ // display author list
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        $authorlist = Author::all();
        return view('admin.authors.list')
                 ->with(array(
                     'authorlist' => $authorlist
                 ));
    }

    function addAuthor(){ // add author form
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        return view ('admin.authors.add');
    }

    function storeAuthor(Request $request){
        $v = Validator::make($request->all(),[
            'name' => 'required',
            // 'address' => 'required',
            'image' => 'image|nullable|mimes:jpeg,png,jpg|max:10240'
        ]);
        if($v -> fails()){
            return redirect::back()->withErrors($v->messages())->withInput();
        }
        else{
            // handle file upload
            if($request->hasFile('image')){
                // get filename with the extention
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                // get the filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // get just ext
                $extention = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $filenameToStore = $filename . '_' . time() . '.' . $extention;
                // uppload image
                $path = $request->file('image')->move($this->image_path, $filenameToStore);
            }
            else{
                $filenameToStore = 'noimage.jpg';
            }


            $saveAuthor = new Author;
            $saveAuthor->name = Input::get('name');
            $saveAuthor->address = Input::get('address');
            $saveAuthor->email = Input::get('email');
            $saveAuthor->phone = Input::get('phone');
            $saveAuthor->image = $filenameToStore;
            $saveAuthor->publish = Input::get('publish');
            $saveAuthor->save();

            return redirect::to('admin/authorlist')->with('success', 'Author Added Successfully.');
        }
    }

    function editAuthor($id){
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        $author = Author::findorFail($id);
        return view('admin.authors.edit')->with(array('author' => $author));
    }

    function updateAuthor(Request $request, $id){
        // $author = Author::findOrFail($id);
        $v = Validator::make($request->all(),[
            'name' => 'required',
            // 'address' => 'required',
            'image' => 'image|nullable|mimes:jpeg,png,jpg|max:10240'
        ]);
        if($v -> fails()){
            return redirect::back()->withErrors($v->messages())->withInput();
        }
        else{
            $editAuthor = Author::find($id);
            // handle file upload
            if($request->hasFile('image')){
                // delete existing image
                if(File::exists($this->image_path . $editAuthor->image)){
                    File::delete($this->image_path . $editAuthor->image);
                }

                // get filename with the extention
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                // get the filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // get just ext
                $extention = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $filenameToStore = $filename . '_' . time() . '.' . $extention;
                // uppload image
                $path = $request->file('image')->move('uploads/authors/', $filenameToStore);
            }
            else{
                if(!empty($editAuthor->image) && File::exists($this->image_path . $editAuthor->image)){
                    $filenameToStore = $editAuthor->image;
                }
                else $filenameToStore = 'noimage.jpg';
            }

            $editAuthor->name = Input::get('name');
            $editAuthor->address = Input::get('address');
            $editAuthor->email = Input::get('email');
            $editAuthor->phone = Input::get('phone');
            $editAuthor->image = $filenameToStore;
            $editAuthor->publish = Input::get('publish');
            $editAuthor->save();

            return redirect::to('admin/authorlist')->with('success', 'Author Updated Successfully.');
        }
    }

    function deleteAuthor($id){
        try{
            $books = BookAuthorRelation::where('authorId', $id)->get();
            if(count($books) == 0){
                $author = Author::find($id);
                if(File::exists($this->image_path . $author->image)){
                        File::delete($this->image_path . $author->image);
                }
                Author::destroy($id);
            }
            else{
                return redirect::back()->with('warning', 'Author can not be Deleted. There are Books under it.');
            }
        } catch(\Exception $e){
            return redirect::back()
                ->with('errors','Can Not be Deleted');

        }
        return redirect::to('admin/authorlist')->with('success', 'Author Deleted Successfully.');
    }

    function deleteAuthorImageAjax(Request $request){
        $author = Author::findOrFail($request->id);
        if(File::exists($this->image_path . $author->image)){
            File::delete($this->image_path . $author->image);
            $author->image = 'noimage.jpg';
            $author->save();
            echo true;
        }
        else{
            echo false;
        }
    }

}
