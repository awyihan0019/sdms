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
                            <option value="UI" selected>User Interface</option>
                            @else
                            <option value="UI">User Interface</option>
                            @endif
                            @if ($issue['category'] == 'Func')
                            <option value="Func" selected>Functionality</option>
                            @else
                            <option value="Func">Functionality</option>
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
                <div class="form-group">
                    <input type="hidden" name="project_id" value="{{ $project['id'] }}">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Edit" />
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-left:200px; width:70%">
        <div class="col-md-12">
            <h2>Comment</h2>
            {{-- <a href="{{route('comment', ['issue_id'=>$issue['id']])}}" class="btn btn-warning float-right" align="right">Comment</a> --}}
        </div>

    </div>
    @endsection
