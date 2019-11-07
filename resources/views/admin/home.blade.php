@extends('admin.layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')

    <!-- Page Title and Breadcrumbs-->
    <ol class="breadcrumb">
        <li> Welcome to Dashboard Control Panel</li>
        <li class="breadcrumb-item">
            <a href="{{ config('app.adminurl') }}">Dashboard</a> / Overview
        </li>
    </ol>
@endsection

@section('otherscripts')
@endsection