@extends('admin.layouts.admin')

@section('title')
    Book Edit
@endsection

@section('otherstyles')
    <style>
        .card-form{margin-left: 0 !important}
        #image, #bookPDF{ display: inline;width: 55%;padding: 2%; }
        @media (max-width: 576px){
            #image, #bookPDF{ display: block; width: 100%; }
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
            #deleteBlock div img{ max-width: 60%; }
            #loading{ position: absolute; left: 42%; top: 40vh; width: 16%; display: none; }

            .blur-body >:not(#loading) {
              /*filter: blur(5px);*/ opacity: 0.4; pointer-events: none;
            }
        /* image delete ajax css ends */

        /* year-month block css */
            .year-month{ display: flex; justify-content: space-between; }
            .year-month div{ width: 49%; }
        /* year-month block css ends */

    </style>

    {{-- css include for multiple selection --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('authorselection/chosen.min.css') }}">
    <style type="text/css">
        .dropdown-author ul{ padding: 2% !important; font-size: 15px; }
        .dropdown-author ul li input{ color: #495057 }
    </style>
    {{-- css include for multiple selection --}}

@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb">
        <li>Edit a Book</li>
        <li class="breadcrumb-item">
            <a href="{{ config('app.adminurl') }}">Dashboard</a> / Book / Bookedit
        </li>
    </ol>

    <form id="bookForm" method="POST" action="{{config('app.adminurl')}}updateabook/{{$book->id}}" enctype="multipart/form-data">
        <div class="row" style="justify-content: space-between; margin-left: 0; margin-right: 0;">
            <div class="card card-form mx-auto mt-12 col-sm-6">
                <div class="card-body">
                    {!! csrf_field() !!}
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="name" class="form-control" placeholder="Book Title" name="name" value="{{ $book->name }}" required>
                            <label for="name">Book Title</label>                         
                        </div>
                        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="isbn" class="form-control" placeholder="ISBN" name="isbn" value="{{ $book->isbn }}">
                            <label for="isbn">ISBN</label>                         
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group year-month">
                            <div>
                                <select class="form-control" name="publishedYear" style="height:3em;" 
                                required>
                                    <option value="">Select Published Year</option>
                                    @php 
                                    $currentNepaliYear = getCurrentNepaliYear();
                                    @endphp
                                    @for ($year = $currentNepaliYear; $year > 1700; $year--) {
                                        <option value="{{$year}}" @if($year == $book->publishedYear) selected @endif>
                                            {{$year}}
                                        </option>
                                    }
                                    @endfor
                                </select>
                                @if ($errors->has('publishedYear')) <p class="help-block">{{ $errors->first('publishedYear') }}</p> @endif
                            </div>
                            <div>
                                <select class="form-control" name="publishedMonth" style="height:3em;">
                                    <option value="">Select Published Month</option>
                                    @php
                                        $monthArray = getNepaliMonth();
                                        for ($month = 1; $month <= 12; $month++) {
                                            if($book->publishedMonth == $month) $selected = 'selected';
                                            else $selected = ''; 
                                            echo '<option value="' . $month . '"'.$selected.'>'.$monthArray[$month].'</option>';
                                        }
                                    @endphp
                                </select>
                            </div>                        
                        </div>
                    </div>
                    {{-- <div class="form-group ">
                        <div class="form-label-group">
                            <input type="date" id="publishedDate" class="form-control" placeholder="Published Date" name="publishedDate" value="{{ $book->publishedDate }}" required>
                            <label for="publishedDate">Published Date</label>                         
                        </div>
                        @if ($errors->has('publishedDate')) <p class="help-block">{{ $errors->first('publishedDate') }}</p> @endif
                    </div> --}}
                    {{-- <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="publisher" class="form-control" placeholder="Publisher" name="publisher" value="{{ $book->publisher }}" required>
                            <label for="publisher">Publisher</label>                         
                        </div>
                        @if ($errors->has('publisher')) <p class="help-block">{{ $errors->first('publisher') }}</p> @endif
                    </div> --}}
                    <div class="form-group">
                        <div class="form-label-group">
                            <select class="form-control" name="bookPublisher" style="height:3em;" required>
                                <option value="">Select Book Publisher</option>
                                @foreach($bookPubList as $bookPub)
                                    <option value="{{ $bookPub->id }}" <?php if($book->bookPublisher == $bookPub->id) echo 'selected' ?> >{{ $bookPub->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('bookPublisher')) <p class="help-block">{{ $errors->first('bookPublisher') }}</p> @endif
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="number" id="noOfPages" class="form-control" placeholder="Number of Pages" name="noOfPages" value="{{ $book->noOfPages }}" min="1" required>
                            <label for="noOfPages">Number of Pages</label>                         
                        </div>
                        @if ($errors->has('noOfPages')) <p class="help-block">{{ $errors->first('noOfPages') }}</p> @endif
                    </div>

                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="edition" class="form-control" placeholder="Edition" name="edition" value="{{ $book->edition }}">
                            <label for="edition">Edition</label>                         
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="ddcCallNumber" class="form-control" placeholder="DDC Call Number" name="ddcCallNumber" value="{{ $book->ddcCallNumber }}">
                            <label for="ddcCallNumber">DDC Call Number</label>                         
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="form-label-group">
                            <b>Old Authors : </b> 
                            @foreach($oldAuthors as $author){
                                {{$author->name}}
                            }
                            @endforeach
                            <select name="" id="foo_select" class="dropdown-author" form="foo_form" multiple data-placeholder="Click to Select Authors" style="width: 100%" required>
                                @foreach($authorList as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </select>                         
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <select class="form-control" name="bookCategory" style="height:3em;" required>
                                <option value="">Select Book Category</option>
                                @foreach($bookCatList as $bookCat)
                                    <option value="{{ $bookCat->id }}" <?php if($book->bookCategory == $bookCat->id) echo 'selected' ?> >{{ $bookCat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('bookCategory')) <p class="help-block">{{ $errors->first('bookCategory') }}</p> @endif
                    </div>
                
                </div>
            </div>

            <div class="card card-form mx-auto mt-12 col-sm-6">
                <div class="card-body">
                    @if(!empty($book->image) && file_exists('uploads/books/images/' . $book->image))
                        <div class="form-group" id="deleteBlock">
                            <div class="form-label-group">
                                <b>Existing Cover Image</b><br>
                                <p class="deleteIcon" title="Delete this image"><i class="fa fa-window-close"></i></p><br>
                                <img src="{{config('app.url')}}uploads/books/images/{{$book->image}}">
                            </div>
                        </div> 
                    @endif
                    <div class="form-group">
                        <div class="form-label-group">
                           Change Cover Image :<br>
                           <input type="file" id="image" class="form-control" name="image">
                           <b>( jpeg,png,jpg, max:2MB )</b>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            Upload New Book as PDF : ( <b>Old : {{$book->bookPDF}}</b> )<br>
                            <input type="file" id="bookPDF" class="form-control" name="bookPDF">
                            <b>( PDF, max : 100MB )</b>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="keywords" class="form-control" placeholder="Keywords" name="keywords" value="{{ $book->keywords }}">
                            <label for="keywords">Keywords</label>                         
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="form-label-group">
                            Featured : 
                            <label class="stylish-radio">
                                Yes &nbsp;
                                <input type="radio" checked="checked" name="featured" value="1">
                                <span class="checkmark"></span>
                            </label>
                            <label class="stylish-radio">
                                &nbsp;&nbsp; No &nbsp;
                                <input type="radio" name="featured" value="0" @if($book->featured == 0) checked @endif>
                                <span class="checkmark"></span>
                            </label>     
                        </div>
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
                                <input type="radio" name="publish" value="0" @if($book->publish == 0) checked @endif>
                                <span class="checkmark"></span>
                            </label>     
                        </div>
                    </div>
                    <input id="submitButton" type="submit" name="edit" value="Update Book" class="btn btn-primary">
                    <input type="reset" name="reset" value="Reset" class="btn btn-primary">
                    <a href="{{config('app.adminurl')}}booklist" class="btn btn-primary">Cancel</a>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('otherscripts')
    
    {{-- jquery include for multiple selection --}}
    <script type="text/javascript" src="{{ asset('authorselection/jquery-2.2.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('authorselection/chosen.jquery.js') }}"></script>
    <script type="text/javascript">
        window.WDS_Chosen_Multiple_Dropdown = {};
        ( function( window, $, that ) {
            // Constructor.
            that.init = function() {
                that.cache();

                if ( that.meetsRequirements ) {
                    that.bindEvents();
                }
            };

            // Cache all the things.
            that.cache = function() {
                that.$c = {
                    window: $(window),
                    theDropdown: $( '.dropdown-author' ),
                };
            };

            // Combine all events.
            that.bindEvents = function() {
                that.$c.window.on( 'load', that.applyChosen );
            };

            // Do we meet the requirements?
            that.meetsRequirements = function() {
                return that.$c.theDropdown.length;
            };

            // Apply the Chosen.js library to a dropdown.
            // https://harvesthq.github.io/chosen/options.html
            that.applyChosen = function() {
                that.$c.theDropdown.chosen({
                    inherit_select_classes: true,
                    width: '100%',
                });
            };

            // Engage!
            $( that.init );

        })( window, jQuery, window.WDS_Chosen_Multiple_Dropdown );
    </script>
    {{-- jquery include for multiple selection ends --}}

    {{-- jquery to append author ids in form submit --}}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#bookForm').submit(function(){
                // alert('inside'); return false;
                var authors = $(".search-choice-close");
                // var checkboxes = '';
                for(var i = 0; i< authors.length; i++){
                    var intValue = parseInt(authors[i].getAttribute("data-option-array-index")) + 1;
                    var checkbox = document.createElement('input');
                    checkbox.setAttribute("type", "checkbox");
                    checkbox.setAttribute("style", "display:none");
                    checkbox.setAttribute("name", "authors[]");
                    checkbox.setAttribute("value", intValue);
                    checkbox.setAttribute("checked", "checked");
                    // var checkbox = '<input style="display:none" type="checkbox" name="authors[]" value="' + intValue + '">';
                    // checkboxes += checkbox;
                    document.getElementById('bookForm').appendChild(checkbox);
                }
                // $('#bookSubmit').html($('#bookSubmit').html() + checkboxes);
                // $('#bookForm').submit();
            });

            {{-- jquery display authors in edit page --}}
                // var authorListBlock = $(document).find('#foo_select_chosen');
                // // alert(authorListBlock.innerHTML); 
                // // $('div.chosen-container')[0].find('ul.chosen-choices');
                {{-- @foreach ($oldAuthors as $author) { --}}
                //     var li = document.createElement('li');
                //     li.setAttribute("class", "search-choice");
                //     var span = document.createElement('span');
                {{-- span.appendChild(document.createTextNode('{{$author->name}}')); --}}
                //     var a = document.createElement('a');
                //     a.setAttribute("class", "search-choice-close");
                {{-- a.setAttribute("data-option-array-index", {{$author->id}}); --}}
                //     li.appendChild(span);
                //     li.appendChild(a);
                //     authorListBlock.prepend(li);
                // }
                {{-- @endforeach --}}
            {{-- jquery display authors in edit page ends --}}
        });
    </script>
    {{-- jquery to append author ids in form submit ends --}}

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
                        id:{{$book->id}} },
                    type: 'POST',
                    url: '{{ config('app.adminurl') }}deletebookcoverimageajax',
                    dataType: 'html',
                    success: function (data) {
                        console.log(data);
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