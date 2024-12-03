@extends('administrator.layouts.master')
@section('content-header')
    @include('administrator.components.content-header', ['route' => route('admin.dashboard'), 'key' => 'Dashboard', 'name' => 'Home'])
@endsection
@section('title')
    <title>Dashboard</title>
@endsection
@section('content')

@endsection
