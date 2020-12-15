@extends('client.layouts.client')

@section('title')
    Archived Book Display
@endsection

@section('otherstyles')
	<link rel="stylesheet" href="{{ asset('client/bookflip/css/style.css') }}">
	<style>
		.category-container { padding: 1%; border: 1px solid #f5f0f0; margin-left: 0;margin-right: 0 }


		.bookInfo div div p:first-child{ font-weight: bold; width: }
		.bookInfo div div span{
			margin:0 0.5% 0 0;padding: 0px 1%;border: 1px solid #aaa;border-radius: 3px;background-color: #eee; 
			box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0,0,0,.05);color: #333;cursor: pointer; 
		}

    </style>
@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb" id="breadcrumb">
        <li>{{$mainBook->name}} : <b>( Archived - {{$archivedBook->publishedYear}} ) | {{$category->name}}</b></li>
        <li>
            <a href="#" data-toggle="modal" data-target="#infoModal" class="btn btn-primary" style="line-height: 1;">Book Info</a>
            <a style="line-height: 1;" class="btn btn-primary" href="{{config('app.url')}}archivedbooks/{{$mainBook->id}}">
                Back
            </a>
        </li>
    </ol>

    <div class="row col-sm-12" style="padding: 0;margin: 0">
    	<div class="sample-container">
		  	<div>

		  	</div>
		</div>
	</div>


	<!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb" style="margin-top: 3%;">
        <li>Related Achived Books of <b>{{$mainBook->name}}</b></li>
    </ol>
	<div class="row col-sm-12 category-container">
		@foreach($otherArchivedBooksOfBook as $bookRow)
		    <div class="card col-sm-2">
			  <a href="{{config('app.url')}}archivedbooksingle/{{$bookRow->id}}"><img src="@if(!empty($bookRow->image) && file_exists('uploads/books/images/' . $bookRow->image)){{config('app.url')}}uploads/books/images/{{$bookRow->image}}@endif" alt="{{$mainBook->name}}"></a>
			  <a href=""><h4>{{$mainBook->name}}</h4></a>
			</div>
		@endforeach
	</div>

@endsection

@section('otherscripts')
	<script src="{{ asset('client/bookflip/js/html2canvas.min.js') }}"></script>
	<script src="{{ asset('client/bookflip/js/three.min.js') }}"></script>
	<script src="{{ asset('client/bookflip/js/pdf.min.js') }}"></script>
	<script src="{{ asset('client/bookflip/js/3dflipbook.min.js') }}"></script>
	<script type="text/javascript">
		$('.sample-container div').FlipBook({pdf: '{{config('app.url')}}uploads/books/pdfs/{{$archivedBook->bookPDF}}'});
	</script>

	{{-- animate to specific id on page load --}}
	<script type="text/javascript">
		$(document).ready(function () {
		    $('html, body').animate({
		        scrollTop: $('#breadcrumb').offset().top
		    }, 'slow');
		});
	</script>

	{{-- book info modal --}}
	<div class="modal fade" id="infoModal">
        <div class="modal-dialog" style="max-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $mainBook->name }} | Book Information</h5>
                </div>
                <div class="modal-body">
                	<div class="bookInfo">
                		<div class="col-sm-12">
                			<div class="row">
                				<p class="col-sm-3">Book Name</p>
                				<p class="col-sm-9">{{ $mainBook->name }}</p>
                			</div>
                			<div class="row">
                				<p class="col-sm-3">ISBN</p>
                				<p class="col-sm-9">{{ $archivedBook->isbn }}</p>
                			</div>
                			<div class="row">
                				<p class="col-sm-3">Published Year</p>
                				<p class="col-sm-9">
                                    {{ $archivedBook->publishedYear }}
                                    @if(!empty($archivedBook->publishedMonth))
                                        | {{getNepaliMonth($archivedBook->publishedMonth)}}
                                    @endif
                                </p>
                			</div>
                			<div class="row">
                				<p class="col-sm-3">Publisher</p>
                				<p class="col-sm-9">{{ $publisher->name }}</p>
                			</div>
                			<div class="row">
                				<p class="col-sm-3">No of Pages</p>
                				<p class="col-sm-9">{{ $archivedBook->noOfPages }}</p>
                			</div>

                            <div class="row">
                                <p class="col-sm-3">Book Edition</p>
                                <p class="col-sm-9">{{ $archivedBook->edition }}</p>
                            </div>

                            <div class="row">
                                <p class="col-sm-3">DDC Call Number</p>
                                <p class="col-sm-9">{{ $archivedBook->ddcCallNumber }}</p>
                            </div>

                			<div class="row">
                				<p class="col-sm-3">Category</p>
                				<p class="col-sm-9">{{ $category->name }}</p>
                			</div>
                			<div class="row">
                				<p class="col-sm-3">Authors</p>
                				<p class="col-sm-9">
                					@foreach($authors as $author)
                						<span>{{ $author->name }}</span>
                					@endforeach
                				</p>
                			</div>
                		</div>
                	</div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- book info modal ends --}}

@endsection