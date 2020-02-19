@extends('layouts.app')

@section('content')

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="{{ asset('css/master.css')}}" rel="stylesheet" type="text/css"/>
@php
if (isset($issues)) {
    dd($issues);
}
@endphp
<div class="w3-sidebar w3-bar-block" style="width:10%;min-width: 150px;background-color: #009688;" >
    <h3 class="w3-bar-item" >Menu</h3>
    <a href="{{action('ProjectController@show', $project['id'])}}" class="w3-bar-item w3-button current">Project</a>
    <a href="{{route('issue_index', ['project_id'=>$project['id']])}}" class="w3-bar-item w3-button current">Issues</a>
    <a href="{{route('issue_create', ['project_id'=>$project['id']])}}" class="w3-bar-item w3-button current">Add Issue</a>
</div>
<div class="container" style="margin-left:150px">
    <div>
        <h1>{{$project['project_name']}}</h1>
    </div>
@endsection
