@extends('layouts.app')

@include('project_navbar')

@section('content')
<div class="row" style="margin-left:200px; width:70%">
    <div class="col-md-12">
        <br />
        <h3>Edit Issue</h3>
        <br />
        @if(count($errors) > 0)

        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            @endif
            <form method="post" action="{{action('IssueController@update', $issue['id'])}}">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH" />
                <div class="form-group" style="max-width:200px">
                    <select type="text" name="type" class="form-control">
                        <option value="" disabled>Issue Type</option>
                        @if ($issue['type'] == 'task')
                        <option value="task" selected>Task</option>
                        @else
                        <option value="task">Task</option>
                        @endif
                        @if ($issue['type'] == 'bug')
                        <option value="bug" selected>Bug</option>
                        @else
                        <option value="bug">Bug</option>
                        @endif
                        @if ($issue['type'] == 'request')
                        <option value="request" selected>Request</option>
                        @else
                        <option value="request">Request</option>
                        @endif
                        @if ($issue['type'] == 'other')
                        <option value="other" selected>Other</option>
                        @else
                        <option value="other">Other</option>
                        @endif
                    </select>
                </div>
                <div class="form-group" style="width:100%">
                    <input type="text" name="subject" class="form-control" value="{{ strval($issue['subject']) }}" />
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea type="text" cols="40" rows="5" name="description"
                        class="form-control">{{ $issue['description'] }}</textarea>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="description">Priority</label>
                        <select type="text" name="priority" class="form-control">
                            <option value="" disabled selected></option>
                            @if ($issue['priority'] == 'high')
                            <option value="high" selected>High</option>
                            @else
                            <option value="high">High</option>
                            @endif
                            @if ($issue['priority'] == 'normal')
                            <option value="normal" selected>Normal</option>
                            @else
                            <option value="normal">Normal</option>
                            @endif
                            @if ($issue['priority'] == 'low')
                            <option value="low" selected>Low</option>
                            @else
                            <option value="low">Low</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="description">Severity</label>
                        <select type="text" name="severity" class="form-control">
                            <option value="" disabled selected></option>
                            @if ($issue['severity'] == 'high')
                            <option value="high" selected>High</option>
                            @else
                            <option value="high">High</option>
                            @endif
                            @if ($issue['severity'] == 'normal')
                            <option value="normal" selected>Normal</option>
                            @else
                            <option value="normal">Normal</option>
                            @endif
                            @if ($issue['severity'] == 'low')
                            <option value="low" selected>Low</option>
                            @else
                            <option value="low">Low</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="description">Category</label>
                        <select type="text" name="category" class="form-control">
                            <option value="" disabled></option>
                            @if ($issue['category'] == 'UI')
                            <option value="UI" selected>Open</option>
                            @else
                            <option value="UI">Open</option>
                            @endif
                            @if ($issue['category'] == 'Func')
                            <option value="Func" selected>In Progress</option>
                            @else
                            <option value="Func">In Progress</option>
                            @endif
                            @if ($issue['category'] == 'DB')
                            <option value="DB" selected>Database</option>
                            @else
                            <option value="DB">Database</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="description">Project Version</label>
                        <input type="text" name="version" class="form-control" value="{{ $issue['version'] }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="due_date">Due Date</label>
                        <input type="date" name="due_date" class="form-control" value="{{ $issue['due_date'] }}" />
                    </div>
                    <div class="col-sm-6">
                        <label for="description">Assignee</label>
                        <select type="text" name="assigned_user_id" class="form-control">
                            <option value="" disabled selected></option>
                            @foreach ($project_members as $row)
                            @if ($issue['assigned_user_id'] == $row['id'])
                            <option value={{ $row['id'] }} selected>{{ $row['name'] }}</option>
                            @else
                            <option value={{ $row['id'] }}>{{ $row['name'] }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="description">Status</label>
                        <select type="text" name="status" class="form-control">
                            <option value="" disabled></option>
                            @if ($issue['status'] == 'open')
                            <option value="open" selected>Open</option>
                            @else
                            <option value="open">Open</option>
                            @endif
                            @if ($issue['status'] == 'in_progress')
                            <option value="in_progress" selected>In Progress</option>
                            @else
                            <option value="in_progress">In Progress</option>
                            @endif
                            @if ($issue['status'] == 'resolved')
                            <option value="resolved" selected>Resolved</option>
                            @else
                            <option value="resolved">Resolved</option>
                            @endif
                            @if ($issue['status'] == 'closed')
                            <option value="closed" selected>Closed</option>
                            @else
                            <option value="closed">Closed</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="exampleFormControlFile1">External File</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="project_id" value="{{ $project['id'] }}">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" aglin="right" value="Update Issue" />
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div style="margin-left:200px; width:70%">
        <h2 class="reviews">Comment <a href="{{route('add_comment', ['issue_id'=>$issue['id']])}}"
                class="btn btn-secondary float-right">Add Comment</a></h2>
        <br>
        @if (empty($comments))
        <div class="card">
            <div class="card-body">
                <div>
                    <p class="card-text">No any comment found.</p>
                </div>
            </div>
        </div>
        @else
        @foreach($comments ?? '' as $row)
        <div class="card">
            <div class="card-body">
                <div>
                    <h5 class="card-title">{{$row['comment_user_id']}}</h5>
                    <p class="card-text">{{$row['content']}}</p>
                </div>
            </div>
            <div class="card-footer text-muted">{{$row['created_at']}}</div>
        </div>
        @endforeach
        @endif
    </div>
    @endsection
