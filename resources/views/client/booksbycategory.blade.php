@extends('client.layouts.client')

@section('title')
    Book List
@endsection

@section('otherstyles')
    <style>
		.category-container { padding: 1%; border: 1px solid #f5f0f0; margin-left: 0;margin-right: 0 }
    </style>
@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb">
        <li>Book List : {{$categoryName}}</li>
        <li><a style="line-height: 1" class="btn btn-primary" href="{{config('app.url')}}">Back</a></li>
    </ol>

    <div class="row col-sm-12 category-container">
		@foreach($books as $book)
		    <div class="card col-sm-2">
			  	<a href="{{config('app.url')}}booksingle/{{$book->id}}">
			  		<img src="@if(!empty($book->image) && file_exists('uploads/books/images/' . $book->image)){{config('app.url')}}uploads/books/images/{{$book->image}} @endif" alt="{{$book->name}}">
			  	</a>
			  	<a href=""><h4>{{$book->name}}</h4></a>
			</div>
		@endforeach
	</div>

@endsection

@section('otherscripts')
@endsection