@extends('layouts.app')

@include('project_navbar')

@section('content')

<div class="container" style="margin-left:150px">
    <a href="{{route('add_member', ['project_id'=>$project['id']])}}" class="btn btn-warning float-right" align="right">Add Member</a>
    <div>
        <h1>{{$project['project_name']}}</h1>
    </div>
@endsection
