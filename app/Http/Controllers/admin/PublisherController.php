<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use Publisher Model
use App\Publisher;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use Response;

use Auth;
use DB;

class PublisherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function index(){ // display publisher list
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        $publisherlist = Publisher::all();
        return view('admin.publishers.list')
                 ->with(array(
                     'publisherlist' => $publisherlist
                 ));
    }

    function addPublisher(){ // add user form
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        return view ('admin.publishers.add');
    }

    function storePublisher(Request $request){
        $v = Validator::make($request->all(),[
            'name' => 'required|unique:book_publishers,name'
        ]);
        if($v -> fails()){
            return redirect::back()->withErrors($v->messages())->withInput();
        }
        else{
            $savePublisher = new Publisher;
            $savePublisher->name = Input::get('name');
            $savePublisher->publish = Input::get('publish');
            $savePublisher->save();

            return redirect::to('admin/publisherlist')->with('success', 'Publisher Added Successfully.');
        }
    }

    function editPublisher($id){
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        $publisher = Publisher::findorFail($id);
        return view('admin.publishers.edit')->with(array('publisher' => $publisher));
    }

    function updatePublisher(Request $request, $id){
        $publisher = Publisher::findOrFail($id);
        $v = Validator::make($request->all(),[
            'name' => 'required|unique:book_publishers,name,'.$publisher->id
        ]);
        if($v -> fails()){
            return redirect::back()->withErrors($v->messages())->withInput();
        }
        else{
            $editPublisher = Publisher::find($id);
            $editPublisher->name = Input::get('name');
            $editPublisher->publish = Input::get('publish');
            $editPublisher->save();

            return redirect::to('admin/publisherlist')->with('success', 'Publisher Updated Successfully.');
        }
    }

    function deletePublisher($id){
        try{
            $books = Publisher::find($id)->getBooks;
            if(count($books) == 0){
                Publisher::destroy($id);
            }
            else{
                return redirect::back()->with('warning', 'Publisher can not be Deleted. There are Books under it.');
            }
        } catch(\Exception $e){
            return redirect::back()
                ->with('errors','Can Not be Deleted');

        }
        return redirect::to('admin/publisherlist')->with('success', 'Publisher Deleted Successfully.');
    }
}
