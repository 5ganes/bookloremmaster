@extends('admin.layouts.admin')

@section('title')
    Author Add
@endsection

@section('otherstyles')
    <style>
        .card-form{margin-left: 0 !important}
        #image{ display: inline;width: 55%;padding: 2%; }
        @media (max-width: 576px){
            #image{ display: block; width: 100%; }
        }

        /* radio button css */
        .stylish-radio{ position: inherit !important; display: inline !important; padding-left: 35px; margin-bottom: 12px; cursor: pointer;
            font-size: 17px; user-select: none; }
        .stylish-radio input { position: absolute; opacity: 0; cursor: pointer; }
        .checkmark { position: absolute; height: 20px; width: 20px; background-color: #e0dbdb; 
            border-radius: 50%; margin-top: 4%; }
        .stylish-radio:hover input ~ .checkmark { background-color: #b5b1b1; }
        .stylish-radio input:checked ~ .checkmark { background-color: #2196F3; }
        .checkmark:after { content: ""; position: absolute; display: none; }
        .stylish-radio input:checked ~ .checkmark:after { display: block; }
        .stylish-radio .checkmark:after { top: 6px; left: 6px; width: 8px; height: 8px; border-radius: 50%;background: white;
        }
        /* radio button css ends */

    </style>
@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb">
        <li>Add an Author</li>
        <li class="breadcrumb-item">
            <a href="{{ config('app.adminurl') }}">Dashboard</a> / Author / Authoradd
        </li>
    </ol>

    <div class="card card-form mx-auto mt-12 col-sm-6">
        <div class="card-body">
            <form method="POST" action="{{config('app.adminurl')}}storeauthor" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="form-group ">
                    <div class="form-label-group">
                        <input type="text" id="name" class="form-control" placeholder="Author Name" name="name" required value="{{ old('name') }}">
                        <label for="name">Author Name</label>                         
                    </div>
                    @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                </div>
                <div class="form-group ">
                    <div class="form-label-group">
                        <input type="text" id="address" class="form-control" placeholder="Address" name="address" value="{{ old('address') }}">
                        <label for="address">Address</label>                         
                    </div>
                </div>
                <div class="form-group ">
                    <div class="form-label-group">
                        <input type="text" id="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                        <label for="email">Email</label>                         
                    </div>
                </div>
                <div class="form-group ">
                    <div class="form-label-group">
                        <input type="text" id="phone" class="form-control" placeholder="Phone" name="phone" value="{{ old('phone') }}">
                        <label for="phone">Phone</label>                         
                    </div>
                </div>
                <div class="form-group ">
                    <div class="form-label-group">
                        <b>Image :</b><br>
                        <input type="file" id="image" class="form-control" name="image">
                        <b>( jpeg,png,jpg, max:2MB )</b>
                    </div>
                    @if ($errors->has('image')) <p class="help-block">{{ $errors->first('image') }}</p> @endif
                </div>

                <div class="form-group ">
                    <div class="form-label-group">
                        Publish : 
                        <label class="stylish-radio">
                            Yes &nbsp;
                            <input type="radio" checked="checked" name="publish" value="1">
                            <span class="checkmark"></span>
                        </label>
                        <label class="stylish-radio">
                            &nbsp;&nbsp; No &nbsp;
                            <input type="radio" name="publish" value="0">
                            <span class="checkmark"></span>
                        </label>     
                    </div>
                </div>
                
                <input type="submit" name="add" value="Add Author" class="btn btn-primary">
                <input type="reset" name="reset" value="Reset" class="btn btn-primary">
                <a href="{{config('app.adminurl')}}authorlist" class="btn btn-primary">Cancel</a>
            
            </form>
            </div>
        </div>
    </div>

@endsection

@section('otherscripts')

@endsection