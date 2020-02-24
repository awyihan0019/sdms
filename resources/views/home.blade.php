@extends('layouts.app')

@section('content')
<div class="row justify-content-center" style="width:90%;margin-left:20px">
    <div class="col-md-12 col-sm-12 col-xl-6">
        <div class="card ">
            <div class="card-header"><a data-toggle="collapse" data-target="#show_projects" aria-expanded="false"
                    aria-controls="collapseOne">Projects<i class="fas fa-chevron-down fa-fw"></i><a
                        href="{{action('ProjectController@create')}}" class="btn btn-secondary pull-right">Add
                        Project</a></div>
            <div id="show_projects" class="collapse in show">
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
        </div>
        <div>
            <div class="card">
                <div class="card-header"><a data-toggle="collapse" data-target="#show_issues" aria-expanded="false"
                        aria-controls="collapseOne">Issues<i class="fas fa-chevron-down fa-fw"></i></a></div>
            </div>
            <div id="show_issues" class="collapse in show">
                <table class="table table-hover">
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
                        @if ($row['priority'] == "high")
                        <td class="text-danger">High</td>
                        @elseif($row['priority'] == "normal")
                        <td class="text-primary">Normal</td>
                        @elseif($row['priority'] == "low")
                        <td class="text-success">Low</td>
                        @endif
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
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xl-6">
        <div class="card">
            <div class="card-header"><a data-toggle="collapse" data-target="#show_histories" aria-expanded="false"
                    aria-controls="collapseOne">Dashboard<i class="fas fa-chevron-down fa-fw"></i></div>
        </div>
        <div id="show_histories" class="collapse in show">
            @if (empty($histories))
            <p>No history found</p>
            @else
            @foreach ($histories as $row)
            <div class="card bg-light mb-3">
                <div class="card-header">{{ $row['created_at'] }}</div>
                <div class="card-body">
                    <p class="card-text">{{ $row['action_log'] }}</p>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
