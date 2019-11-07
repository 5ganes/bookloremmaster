@extends('client.layouts.client')

@section('title')
    Archived Book List
@endsection

@section('otherstyles')
    <style>
		.category-container { padding: 1%; border: 1px solid #f5f0f0; margin-left: 0;margin-right: 0 }
    </style>
@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb">
        <li>Archived Book List : {{$mainBook->name}} <b>( Category : {{$categoryName}} )</b></li>
        <a style="line-height: 1;" class="btn btn-primary" href="{{config('app.url')}}booksingle/{{$mainBook->id}}">Back</a>
    </ol>

    <div class="row col-sm-12 category-container">
		@foreach($archivedBooks as $book)
		    <div class="card col-sm-2">
			  	<a href="{{config('app.url')}}archivedbooksingle/{{$book->id}}">
			  		<img src="@if(!empty($book->image) && file_exists('uploads/books/images/' . $book->image)){{config('app.url')}}uploads/books/images/{{$book->image}} @endif" alt="{{$book->name}}">
			  	</a>
			  	<a href=""><h4>{{$book->publishedYear}}</h4></a>
			</div>
		@endforeach
	</div>

@endsection

@section('otherscripts')
@endsection