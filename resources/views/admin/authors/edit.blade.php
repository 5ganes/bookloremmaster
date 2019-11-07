@extends('admin.layouts.admin')

@section('title')
    Edit Author
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

        /* image delete ajax css */
        .deleteIcon{ font-size: 23px;cursor: pointer; margin: 0; display: inline; }
        .deleteIcon:hover i{color:red;}
        #deleteBlock div img{ max-width: 100%; }
        #loading{ position: absolute; left: 42%; top: 40vh; width: 16%; display: none; }

        .blur-body >:not(#loading) {
          /*filter: blur(5px);*/ pointer-events: none; opacity: 0.4;
        }

        /* image delete ajax css ends */
    </style>
@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb">
        <li>Edit Author</li>
        <li class="breadcrumb-item">
            <a href="{{ config('app.adminurl') }}">Dashboard</a> / Author / Editauthor
        </li>
    </ol>

    <div class="row" style="justify-content: space-between; margin-left: 0; margin-right: 0;">
        <div class="card card-form mx-auto mt-12 col-sm-6">
            <div class="card-body">
                <form method="POST" action="{{config('app.adminurl')}}updateauthor/{{$author->id}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="name" class="form-control" placeholder="Author Name" name="name" required value="{{ $author->name }}">
                            <label for="name">Author Name</label>                         
                        </div>
                        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="address" class="form-control" placeholder="Address" name="address" value="{{ $author->address }}">
                            <label for="address">Address</label>                         
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="email" class="form-control" placeholder="Email" name="email" value="{{ $author->email }}">
                            <label for="email">Email</label>                         
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="phone" class="form-control" placeholder="Phone" name="phone" value="{{ $author->phone }}">
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
                                <input type="radio" name="publish" value="0" @if($author->publish == 0) checked @endif>
                                <span class="checkmark"></span>
                            </label>     
                        </div>
                    </div>
                    
                    <input type="submit" name="update" value="Update Author" class="btn btn-primary">
                    <input type="reset" name="reset" value="Reset" class="btn btn-primary">
                    <a href="{{config('app.adminurl')}}authorlist" class="btn btn-primary">Cancel</a>
                </form>
            </div>
        </div>

        <div class="card card-form mx-auto mt-12 col-sm-5">
            <div class="card-body">
                @if(!empty($author->image) && file_exists('uploads/authors/' . $author->image))
                    <div class="form-group" id="deleteBlock">
                        <div class="form-label-group">
                            <b>Existing Image</b><br>
                            <p class="deleteIcon" title="Delete this image"><i class="fa fa-window-close"></i></p><br>
                            <img src="{{config('app.url')}}uploads/authors/{{$author->image}}">
                        </div>
                    </div> 
                @endif
            </div>
        </div>
    </div>

@endsection

@section('otherscripts')
    
    {{--  image delete ajax jquery --}}
    <img id="loading" src="{{config('app.url')}}images/loading.gif">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        $(document).ready(function(){
            $('.deleteIcon').click(function(){
                $('#loading').show(); $('body').addClass("blur-body");
                $.ajax({
                    data:{
                        _token: '{!! csrf_token() !!}',
                        id:{{$author->id}} },
                    type: 'POST',
                    url: '{{ config('app.adminurl') }}deleteauthorimageajax',
                    dataType: 'html',
                    success: function (data) {
                        $('#loading').hide(); $('body').removeClass("blur-body");
                        if(data == true){
                            $('#deleteBlock').html('<div class="alert alert-success alert-dismissible" role="alert" style="margin-top:5px;"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success! </strong>Image Deleted Successfully</div>');
                        }
                    },
                });
            });
        });
    </script>
    {{--  image delete ajax jquery ends --}}

@endsection



