@extends('admin.layouts.admin')

@section('title')
    Archived Book Add
@endsection

@section('otherstyles')
    <style>
        .card-form{margin-left: 0 !important}
        #image, #bookPDF{ display: inline;width: 55%;padding: 2%; }
        @media (max-width: 576px){
            #image, #bookPDF{ display: block; width: 100%; }
        }

        /* year-month block css */
            .year-month{ display: flex; justify-content: space-between; }
            .year-month div{ width: 49%; }
        /* year-month block css ends */

    </style>

@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb">
        <li>Add an Archived Book of {{$mainBook->name}}</li>
        <li class="breadcrumb-item">
            <a href="{{ config('app.adminurl') }}">Dashboard</a> / Archived Book / Bookadd
        </li>
    </ol>

    <form id="bookForm" method="POST" action="{{config('app.adminurl')}}storearchivedbook/{{$mainBook->id}}" enctype="multipart/form-data">
        <div class="row" style="justify-content: space-between; margin-left: 0; margin-right: 0;">
            <div class="card card-form mx-auto mt-12 col-sm-6">
                <div class="card-body">
                    {!! csrf_field() !!}
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="name" class="form-control" placeholder="Book Title" name="name" value="{{ $mainBook->name }}" disabled>
                            <label for="name">Book Title</label>                         
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="isbn" class="form-control" placeholder="ISBN" name="isbn" value="{{ $mainBook->isbn }}">
                            <label for="isbn">ISBN</label>                         
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group year-month">
                            <div>
                                <select class="form-control" id="publishedYear" name="publishedYear" style="height:3em;" required>
                                    <option value="">Select Published Year</option>
                                    @php
                                        for ($year = $currentPublishedYear; $year > 1700; $year--) { 
                                            echo '<option value="'.$year.'">'.$year.'</option>';
                                        }
                                    @endphp
                                </select>
                                @if ($errors->has('publishedYear')) <p class="help-block">{{ $errors->first('publishedYear') }}</p> @endif
                            </div>
                            <div>
                                <select class="form-control" id="publishedMonth" name="publishedMonth" style="height:3em;" @if(empty($mainBook->publishedMonth)) disabled @endif>
                                    <option value="">Select Published Month</option>
                                    @php
                                        $monthArray = getNepaliMonth();
                                    @endphp
                                    @for ($month = 1; $month <= 12; $month++) { 
                                        <option value="{{$month}}" @if(old('publishedMonth') == $month) selected @endif>
                                            {{$monthArray[$month]}}
                                        </option>
                                    }
                                    @endfor
                                </select>
                            </div>                         
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="publisher" class="form-control" placeholder="Publisher" name="publisher" value="{{ $mainBook->publisher}}" required>
                            <label for="publisher">Publisher</label>                         
                        </div>
                        @if ($errors->has('publisher')) <p class="help-block">{{ $errors->first('publisher') }}</p> @endif
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="number" id="noOfPages" class="form-control" placeholder="Number of Pages" name="noOfPages" value="{{ $mainBook->noOfPages }}" min="1" required>
                            <label for="noOfPages">Number of Pages</label>                         
                        </div>
                        @if ($errors->has('noOfPages')) <p class="help-block">{{ $errors->first('noOfPages') }}</p> @endif
                    </div>

                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="edition" class="form-control" placeholder="Edition" name="edition" value="{{ old('edition') }}">
                            <label for="edition">Edition</label>                         
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            <input type="text" id="ddcCallNumber" class="form-control" placeholder="DDC Call Number" name="ddcCallNumber" value="{{ old('ddcCallNumber') }}">
                            <label for="ddcCallNumber">DDC Call Number</label>                         
                        </div>
                    </div>
                
                </div>
            </div>

            <div class="card card-form mx-auto mt-12 col-sm-6">
                <div class="card-body">

                    <div class="form-group ">
                        <div class="form-label-group">
                            <b>Authors : </b> 
                            @foreach($authors as $author){
                                {{$author->name}}
                            }
                            @endforeach                         
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <select class="form-control" name="bookCategory" style="height:3em;" disabled>
                                <option value="">{{$mainBook->categoryName}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="form-label-group">
                           Cover Image :<br>
                           <input type="file" id="image" class="form-control" name="image" required>
                           <b>( jpeg,png,jpg, max:2MB )</b>
                        </div>
                        @if ($errors->has('image')) <p class="help-block">{{ $errors->first('image') }}</p> @endif
                    </div>
                    <div class="form-group ">
                        <div class="form-label-group">
                            Upload Book as PDF :<br>
                            <input type="file" id="bookPDF" class="form-control" name="bookPDF" required>
                            <b>( PDF, max : 100MB )</b>
                        </div>
                        @if ($errors->has('bookPDF')) <p class="help-block">{{ $errors->first('bookPDF') }}</p> @endif
                    </div>
                    <input id="submitButton" type="submit" name="add" value="Add Book" class="btn btn-primary">
                    <input type="reset" name="reset" value="Reset" class="btn btn-primary">
                    <a href="{{config('app.adminurl')}}archivedbooklist/{{$mainBook->id}}" class="btn btn-primary">Cancel</a>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('otherscripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#publishedYear').change(function(){
                var monthOptions = $('#publishedMonth option');
                if(this.value == {{$mainBook->publishedYear}}){
                    for(var i = 0; i < monthOptions.length; i++){
                        if(monthOptions[i].value >= {{$mainBook->publishedMonth}}){
                            monthOptions[i].disabled = true;
                        }
                    }
                }
                else{
                    for(var i = 0; i < monthOptions.length; i++){
                        monthOptions[i].disabled = false;
                    }
                }
            });
        });
    </script>
@endsection