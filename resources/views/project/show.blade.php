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
        <div class="col-md-12 col-sm-12 col-xl-10">
            <div class="card">
                <div class="card-header"><a data-toggle="collapse" data-target="#show_histories" aria-expanded="false"
                        aria-controls="collapseOne">Dashboard<i class="fas fa-chevron-down fa-fw"></i></div>
            </div>
            <div id="show_histories" class="collapse in show">
                @if ($histories->first()  != null)
                @foreach ($histories as $row)
                <div class="card bg-light mb-3">
                    <div class="card-header">{{ $row['created_at'] }}</div>
                    <div class="card-body">
                        <p class="card-text">{{ $row['action_log'] }}</p>
                    </div>
                </div>
                @endforeach
                @else
                <p>No history found</p>
                @endif
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xl-1">
            <div class="card" style="width: 10rem;">
                <div class="card-header">Member</div>
                <ul class="list-group list-group-flush">
                    @if ($users->first()  != null)
                    @foreach($users ?? '' as $row)
                    <li class="list-group-item">{{$row['name']}}</li>
                    @endforeach
                    @else
                    <li class="list-group-item">No any user found</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    @endsection
