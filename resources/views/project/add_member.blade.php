@extends('layouts.app')

@include('project_navbar')

@section('content')

<a href="{{action('ProjectController@create')}}" class="btn btn-warning">Add Member</a>
<div class="container" style="margin-left:150px">
    <div>
        <h1>{{$project['project_name']}}</h1>
    </div>
    <br>
    <div>
        <h2>Add New Member</h2>
    </div>
    {{-- @php
        dd($project)
    @endphp --}}

    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(\Session::has('error'))
        <div class="alert alert-success">
            <p>{{ \Session::get('error') }}</p>
        </div>
        @endif

    <form method="post" action="{{url('/project/store_member/{project_id}')}}">
        {{csrf_field()}}
        <div class="form-group">
            <label>E-mail</label>
            <input type="text" name="email" class="form-control" />
        </div>
        <div class="form-group">
            <label for="description">Role</label>
            <select type="text" name="role" class="form-control">
                <option value="Manager">Manager</option>
                <option value="Tester">Tester</option>
                <option value="Member">Member</option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Add Member" />
        </div>
        <div class="form-group">
            <input type="hidden" name="project_id" value="{{ $project['id'] }}">
        </div>
    </form>
    @endsection
