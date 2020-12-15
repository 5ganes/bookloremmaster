@extends('admin.layouts.admin')

@section('title')
    Publisher Add
@endsection

@section('otherstyles')
    <style>
        .card-form{margin-left: 0 !important}

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
        <li>Add Book Publisher</li>
        <li class="breadcrumb-item">
            <a href="{{ config('app.adminurl') }}">Dashboard</a> / Publisher / Publisher
        </li>
    </ol>

    <div class="card card-form mx-auto mt-12 col-sm-6">
        <div class="card-body">
            <form method="POST" action="{{config('app.adminurl')}}storepublisher">
                {!! csrf_field() !!}
                <div class="form-group ">
                    <div class="form-label-group">
                        <input type="text" id="name" class="form-control" placeholder="Publisher Name" name="name" required value="{{ old('name') }}">
                        <label for="name">Publisher Name</label>                         
                    </div>
                    @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
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
                
                <input type="submit" name="add" value="Add Publisher" class="btn btn-primary">
                <input type="reset" name="reset" value="Reset" class="btn btn-primary">
                <a href="{{config('app.adminurl')}}publisherlist" class="btn btn-primary">Cancel</a>
            
            </form>
            </div>
        </div>
    </div>

@endsection

@section('otherscripts')

@endsection