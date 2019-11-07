@extends('admin.layouts.admin')

@section('title')
    User Add
@endsection

@section('otherstyles')
    <style>
        .card-form{margin-left: 0 !important}
    </style>
@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb">
        <li>Add User</li>
        <li class="breadcrumb-item">
            <a href="{{ config('app.adminurl') }}">Dashboard</a> / User / Useradd
        </li>
    </ol>

    <div class="card card-form mx-auto mt-12 col-sm-6">
        <div class="card-body">
            <form method="POST" action="{{config('app.adminurl')}}storeuser">
                {!! csrf_field() !!}
                <div class="form-group ">
                    <div class="form-label-group">
                        <input type="text" id="name" class="form-control" placeholder="Full Name" name="name" required value="{{ old('name') }}">
                        <label for="name">Full Name</label>                         
                    </div>
                    @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="email" id="email" class="form-control" placeholder="Email Address" name="email" required value="{{ old('email') }}">
                        <label for="email">Email Address</label>
                    </div>
                    @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="password" id="password" class="form-control" placeholder="Password" name="password" required value="">
                        <label for="password">Password</label>
                    </div>
                    @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="password" id="confPassword" class="form-control" placeholder="Confirm Password" name="confirmPassword" required>
                        <label for="confPassword">Confirm Password</label>
                    </div>
                    @if ($errors->has('confirmPassword')) <p class="help-block">{{ $errors->first('confirmPassword') }}</p> @endif
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <select class="form-control" name="type" style="height:3em;">
                            <option value="admin">Admin</option>
                            <option value="normal" @if(old('type') == 'normal') selected @endif>normal</option>
                        </select>
                    </div>
                </div>
                <input type="submit" name="add" value="Add User" class="btn btn-primary">
                <input type="reset" name="reset" value="Reset" class="btn btn-primary">
                <a href="{{config('app.adminurl')}}userlist" class="btn btn-primary">Cancel</a>
            </form>
        </div>
    </div>

@endsection

@section('otherscripts')

@endsection