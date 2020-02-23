@extends('layouts.app')

@section('content')
<div class="row justify-content-center" style="width:90%;margin-left:20px">
    <div class="col">
        <div class="card">
            <div class="card-header">Projects<a href="{{action('ProjectController@create')}}"
                    class="btn btn-secondary pull-right">Add Project</a></div>
            <ul class="list-group list-group-flush">
                @if (empty($projects))
                <li class="list-group-item">No any project found</li>
                @else
                @foreach($projects ?? '' as $row)
                <li class="list-group-item"><a
                        href="{{action('ProjectController@show', $row['id'])}}">{{$row['project_name']}}</a></li>
                @endforeach
                @endif
            </ul>
        </div>
        <div class="card">
            <div class="card-header">Issues</div>
        </div>
        <table class="table  table-hover">
            <tr>
                <thead>
                    <th>id</th>
                    <th style="width:10px">Type</th>
                    <th>Subject</th>
                    <th style="width:100px">Assignee</th>
                    <th style="width:100px">Status</th>
                    <th style="width:100px">Priority</th>
                    <th style="width:100px">Due Date</th>
                </thead>
            </tr>
            @if (empty($issues))
            <tr>
                <td>No issue found</td>
            </tr>
            @else
            @foreach ($issues as $row)
            <tr>
                <td>{{$row['id']}}</td>
                <td>{{$row['type']}}</td>
                <td><a href="{{route('issue_edit', ['issue_id'=>$row['id']])}}">{{$row['subject']}}</a></td>
                @if (empty($row['assigned_user_id']))
                <td>Not set</td>
                @else
                <td>{{ $row['assigned_user_id'] }}</td>
                @endif
                <td>{{$row['status']}}</td>
                <td>{{$row['priority']}}</td>
                @if (empty($row['due_date']))
                <td>Not set</td>
                @else
                <td>{{ $row['due_date'] }}</td>
                @endif
            </tr>
            @endforeach
            @endif
        </table>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
