@extends('layouts.project-layout')

@section('project-content')

<div class="row">
    <div class="col-md-12">
        <br />
        <h3>Edit Record</h3>
        <br />
        @if(count($errors) > 0)

        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            @endif
            <label>Current Name : {{$project['project_name']}}</label>
        </div>

    </div>
</div>
        @endsection
