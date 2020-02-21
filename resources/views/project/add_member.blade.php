@extends('layouts.app')

@include('project_navbar')

@section('content')
<a href="{{action('ProjectController@create')}}" class="btn btn-warning">Add Member</a>
<div class="container" style="margin-left:150px">
    <div>
        <h1>{{$project['project_name']}}</h1>
    </div>
    <div class="col-sm-6">
        <label for="description">Assignee</label>
        <select type="text" name="category" class="form-control">
            <option value="" disabled selected></option>
            @foreach ($users as $row)
                <option value={{ $row['id'] }}>{{ $row['name'] }}</option>
            @endforeach
        </select>
    </div>
@endsection
