<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use User Model
use app\User;

use App\Http\Requests;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use Carbon\Carbon;
use DB;
use GH;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){ // display user list
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        $userlist = User::all();
        return view('admin.users.list')
                 ->with(array(
                     'userlist' => $userlist
                 ));
    }

    function addUser(){ // add user form
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        return view ('admin.users.add');
    }

    function storeUser(Request $request){
        $v = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'min:6|required',
            'confirmPassword' => 'min:6|required_with:password|same:password'
        ]);
        if($v -> fails()){
            return redirect::back()->withErrors($v->messages())->withInput();
        }
        else{
            $saveUser = new User;
            $saveUser->name = Input::get('name');
            $saveUser->email = Input::get('email');
            $saveUser->password = Hash::make(Input::get('password'));
            $saveUser->type = Input::get('type');
            $saveUser->save();

            return redirect::to('admin/userlist')->with('success', 'User Added Successfully.');
        }
    }

    function editUser($id){
        if(Auth::user()->type != 'admin'){ return redirect::to('admin/login'); }
        $user = User::findorFail($id);
        return view('admin.users.edit')->with(array('user' => $user));
    }

    function updateUser(Request $request, $id){
        $user = User::findOrFail($id);
        $v = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'min:6|required',
            'confirmPassword' => 'min:6|required_with:password|same:password'
        ]);
        if($v -> fails()){
            return redirect::back()->withErrors($v->messages())->withInput();
        }
        else{
            $editUser = User::find($id);
            $editUser->name = Input::get('name');
            $editUser->email = Input::get('email');
            $editUser->password = Hash::make(Input::get('password'));
            
            if(isset($request->all()['type']))
                $editUser->type = Input::get('type');
            
            $editUser->save();

            return redirect::to('admin/userlist')->with('success', 'User Updated Successfully.');
        }
    }

    function deleteUser($id){
        try{
            $user = User::findOrFail($id);
            if($user->type != 'admin') User::destroy($id);
            else return redirect::to('admin/userlist')->with('error', 'Main User can not be Deleted.');
        } catch(\Exception $e){
            return redirect::back()
                ->with('errors','Can Not be Deleted');

        }
        return redirect::to('admin/userlist')->with('success', 'User Deleted Successfully.');
    }

}






