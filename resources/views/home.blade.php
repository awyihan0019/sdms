@extends('layouts.app')

@section('content')
<div class="row justify-content-center" style="width:90%;margin-left:20px">
    <div class="col-md-12 col-sm-12 col-xl-6">
        <div class="card ">
            <div class="card-header">
                <a data-toggle="collapse" data-target="#show_projects" aria-expanded="false"
                    aria-controls="collapseOne">Projects
                    <i class="fas fa-chevron-down fa-fw"></i>
                    <a href="{{action('ProjectController@create')}}" class="btn btn-secondary pull-right">Add
                        Project</a>
            </div>
            <div id="show_projects" class="collapse in show">
                <ul class="list-group list-group-flush">
                    @if ($projects->first() != null)
                    @foreach($projects ?? '' as $row)
                    <li class="list-group-item"><a
                            href="{{action('ProjectController@show', $row['id'])}}">{{$row['project_name']}}</a></li>
                    @endforeach
                    @else
                    <li class="list-group-item">No any project found</li>
                    @endif
                </ul>
            </div>
        </div>
        <div>
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header">issues
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse"
                                data-parent="#accordionExample" data-target="#collapseOne" aria-expanded="true"
                                aria-controls="collapseOne">
                                All
                            </button>
                            <button class="btn btn-secondary btn-sm collapsed" type="button" data-toggle="collapse"
                                data-parent="#accordionExample" data-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">
                                Assigned to me
                            </button>
                            <button class="btn btn-secondary btn-sm collapsed" type="button" data-toggle="collapse"
                                data-parent="#accordionExample" data-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                                Posted by me
                            </button>
                        </div>
                    </div>
                </div>
                <div class="accordion-group">
                    <div id="collapseOne" class="collapse show in" aria-labelledby="headingOne"
                        data-parent="#accordionExample">
                        <table class="table table-hover">
                            <tr>
                                <thead>
                                    <th style="width:10px">Project</th>
                                    <th>Issue Subject</th>
                                    <th style="width:100px">Status</th>
                                    <th style="width:100px">Priority</th>
                                    <th style="width:100px">Due Date</th>
                                </thead>
                            </tr>
                            @if ($issues->first() != null)
                            @foreach ($issues as $row)
                            <tr>
                                <td>{{ $row->project()->first()['project_name'] }}</td>
                                <td><a
                                        href="{{route('issue_show', ['project_id'=>$row->project()->first()['id'], 'issue_id'=>$row['id']])}}">{{$row['subject']}}</a>
                                </td>
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
                            @else
                            <tr>
                                <td colspan="7">No issue found</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div id="collapseTwo" class="collapse in" aria-labelledby="headingTwo"
                        data-parent="#accordionExample">
                        <table class="table table-hover">
                            <tr>
                                <thead>
                                    <th style="width:10px">Project</th>
                                    <th>Issue Subject</th>
                                    <th style="width:100px">Publisher</th>
                                    <th style="width:100px">Status</th>
                                    <th style="width:100px">Priority</th>
                                    <th style="width:100px">Due Date</th>
                                </thead>
                            </tr>
                            @if ($assignedIssues->first() != null)
                            @foreach ($assignedIssues as $row)
                            <tr>
                                <td>{{ $row->project()->first()['project_name'] }}</td>
                                <td><a
                                        href="{{route('issue_show', ['project_id'=>$row->project()->first()['id'], 'issue_id'=>$row['id']])}}">{{$row['subject']}}</a>
                                </td>
                                @if (empty($row['post_user_id']))
                                <td>Not set</td>
                                @else
                                <td>{{ $row->postedUser()->first()['name'] }}</td>
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
                            @else
                            <tr>
                                <td colspan="7">No issue found</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div id="collapseThree" class="collapse in" aria-labelledby="headingThree"
                        data-parent="#accordionExample">
                        <table class="table table-hover">
                            <tr>
                                <thead>
                                    <th style="width:10px">Project</th>
                                    <th>Issue Subject</th>
                                    <th style="width:100px">Assignee</th>
                                    <th style="width:100px">Status</th>
                                    <th style="width:100px">Priority</th>
                                    <th style="width:100px">Due Date</th>
                                </thead>
                            </tr>
                            @if ($postedIssues->first() != null)
                            @foreach ($postedIssues as $row)
                            <tr>
                                <td>{{ $row->project()->first()['project_name'] }}</td>
                                <td><a
                                        href="{{route('issue_show', ['project_id'=>$row->project()->first()['id'], 'issue_id'=>$row['id']])}}">{{$row['subject']}}</a>
                                </td>
                                @if (empty($row['assigned_user_id']))
                                <td>Not set</td>
                                @else
                                <td>{{ $row->assignedUser()->first()['name'] }}</td>
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
                            @else
                            <tr>
                                <td colspan="7">No issue found</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xl-6">
        <div class="card">
            <div class="card-header"><a data-toggle="collapse" data-target="#show_histories" aria-expanded="false"
                    aria-controls="collapseOne">Dashboard<i class="fas fa-chevron-down fa-fw"></i></a></div>
        </div>
        <div id="show_histories" class="collapse in show">
            @if ($histories->first() != null)
            @foreach ($histories as $row)
            <div class="card bg-light mb-3">
                <div class="card-header">{{ $row['created_at'] }}</div>
                <div class="card-body">
                    <p class="card-text">{!! $row['action_log'] !!}</p>
                </div>
            </div>
            @endforeach
            @else
            <p>No history found</p>
            @endif
        </div>
    </div>
</div>
@endsection
