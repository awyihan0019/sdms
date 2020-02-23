@extends('layouts.app')

@include('project_navbar')

@section('content')

<div class="container" style="margin-left:200px; width:100%">
    <a href="{{route('add_member', ['project_id'=>$project['id']])}}" class="btn btn-secondary float-right">Invite
        User</a>
    <div>
        <h1>{{$project['project_name']}}</h1>
    </div>
    <div class="row">
        <div class=" col" style="width: 70%;">
            all the history log will show at here
        </div>
        <div class="col">
            <div class="card" style="width: 10rem;">
                <div class="card-header">Member</div>
                <ul class="list-group list-group-flush">
                    @if (empty($users))
                    <li class="list-group-item">No any user found</li>
                    @else
                    @foreach($users ?? '' as $row)
                    <li class="list-group-item">{{$row['name']}}</li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    @endsection
