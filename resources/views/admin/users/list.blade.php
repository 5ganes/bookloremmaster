@extends('admin.layouts.admin')

@section('title')
    User Management
@endsection

@section('otherstyles')
    
    {{-- css files for datatable --}}
        <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    {{-- css files for datatable --}}

@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb">
        <li>User List</li>
        <li class="breadcrumb-item">
            <a href="{{ config('app.adminurl') }}">Dashboard</a> / User / Userlist
        </li>
    </ol>

    <a href="{{ config('app.adminurl') }}adduser" class="btn btn-primary btn-sm add-button">
    <i class="fa fa-plus">&nbsp;</i>Add New User</a>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    <tbody>
                        @php $sn = 1 @endphp
                        @foreach ($userlist as $user)
                            <tr>
                                <td>{{$sn++}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->type}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <a href="{{ config('app.adminurl') }}edituser/{{$user->id}}" class="btn btn-default btn-sm">
                                        <i class="fa fa-edit">&nbsp;</i>Edit
                                    </a> &nbsp;
                                    @if($user->type != 'admin')
                                        <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="deleteUrl('{{config('app.adminurl')}}deleteuser/{{$user->id}}')">
                                            <i class="fa fa-trash">&nbsp;</i>Delete
                                        </a>
                                    @endif
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