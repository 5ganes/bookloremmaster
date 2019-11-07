<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use Category Model
use App\Category;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use Response;

use Auth;
use DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function index(){ // display category list
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        $categorylist = Category::all();
        return view('admin.categories.list')
                 ->with(array(
                     'categorylist' => $categorylist
                 ));
    }

    function addCategory(){ // add user form
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        return view ('admin.categories.add');
    }

    function storeCategory(Request $request){
        $v = Validator::make($request->all(),[
            'name' => 'required|unique:book_categories,name'
        ]);
        if($v -> fails()){
            return redirect::back()->withErrors($v->messages())->withInput();
        }
        else{
            $saveCategory = new Category;
            $saveCategory->name = Input::get('name');
            $saveCategory->publish = Input::get('publish');
            $saveCategory->save();

            return redirect::to('admin/categorylist')->with('success', 'Category Added Successfully.');
        }
    }

    function editCategory($id){
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        $category = Category::findorFail($id);
        return view('admin.categories.edit')->with(array('category' => $category));
    }

    function updateCategory(Request $request, $id){
        $category = Category::findOrFail($id);
        $v = Validator::make($request->all(),[
            'name' => 'required|unique:book_categories,name,'.$category->id
        ]);
        if($v -> fails()){
            return redirect::back()->withErrors($v->messages())->withInput();
        }
        else{
            $editCategory = Category::find($id);
            $editCategory->name = Input::get('name');
            $editCategory->publish = Input::get('publish');
            $editCategory->save();

            return redirect::to('admin/categorylist')->with('success', 'Category Updated Successfully.');
        }
    }

    function deleteCategory($id){
        try{
            $books = Category::find($id)->getBooks;
            if(count($books) == 0){
                Category::destroy($id);
            }
            else{
                return redirect::back()->with('warning', 'Category can not be Deleted. There are Books under it.');
            }
        } catch(\Exception $e){
            return redirect::back()
                ->with('errors','Can Not be Deleted');

        }
        return redirect::to('admin/categorylist')->with('success', 'Category Deleted Successfully.');
    }

}
