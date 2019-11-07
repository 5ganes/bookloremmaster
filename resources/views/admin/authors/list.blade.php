@extends('admin.layouts.admin')

@section('title')
    Author Management
@endsection

@section('otherstyles')
    
    {{-- css files for datatable --}}
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    {{-- css files for datatable --}}

@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb">
        <li>Author List</li>
        <li class="breadcrumb-item">
            <a href="{{ config('app.adminurl') }}">Dashboard</a> / Author / Authorlist
        </li>
    </ol>

    <a href="{{ config('app.adminurl') }}addauthor" class="btn btn-primary btn-sm add-button">
    <i class="fa fa-plus">&nbsp;</i>Add New Author</a>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Publish</th>
                            <th>Created At</th>
                            <th style="min-width: 150px;">Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Publish</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    <tbody>
                        @php $sn = 1 @endphp
                        @foreach ($authorlist as $author)
                            <tr>
                                <td>{{$sn++}}</td>
                                <td>
                                    @if(!empty($author->image) && file_exists('uploads/authors/' . $author->image))
                                        <img src="{{config('app.url')}}uploads/authors/{{$author->image}}" width="50" height="30">
                                    @else
                                        <img src="{{config('app.url')}}uploads/noimage.jpg" width="50" height="30">
                                    @endif
                                </td>
                                <td>{{$author->name}}</td>
                                <td>{{$author->address}}</td>
                                <td>{{$author->email}}</td>
                                <td>{{$author->phone}}</td>
                                <td>@if($author->publish == 1) Yes @else No @endif</td>
                                <td>{{$author->created_at->format('Y-m-d')}}</td>
                                <td>
                                    <a href="{{ config('app.adminurl') }}editauthor/{{$author->id}}" class="btn btn-default btn-sm">
                                        <i class="fa fa-edit">&nbsp;</i>Edit
                                    </a> &nbsp;
                                    <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="deleteUrl('{{ config('app.adminurl') }}deleteauthor/{{$author->id}}')">
                                        <i class="fa fa-trash">&nbsp;</i>Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('otherscripts')

    {{-- datatable jquery files --}}
        <script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    {{-- datatable jquery files ends --}}

    {{-- delete script --}}
        <script type="text/javascript">
            function deleteUrl(url){
                var delform = document.getElementById('delete-form');
                delform.setAttribute('action', url);
            }
        </script>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Do You Really Want To Delete This Item?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="#" onclick="event.preventDefault();
                        document.getElementById('delete-form').submit();">Delete</a>
                        
                        {{-- logout form --}}
                        <form id="delete-form" action="" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{-- delete script ends --}}
@endsection