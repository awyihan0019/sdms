@extends('layouts.app')

@include('project_navbar')

@section('content')
<div class="container py-5" style="margin-left:150px;width:100%">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <br />
            <h3 align="center">Issue</h3>
            <br />
            @if($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{$message}}</p>
            </div>
            @endif
            <font size="5">
                <table class="table table-bordered">
                    <tr>
                        <th style="width:10px">Type</th>
                        <th>Subject</th>
                        <th style="width:100px">Assignee</th>
                        <th style="width:100px">Status</th>
                        <th style="width:100px">Priority</th>
                        <th style="width:100px">Due Date</th>
                    </tr>
                    @foreach ($issues as $row)
                    <tr>
                        <td>{{$row['type']}}</td>
                        <td><a href="{{route('issue_edit', ['issue_id'=>$row['id']])}}">{{$row['subject']}}</a></td>
                        @if (empty($row['assigned_id']))
                        <td>Not set</td>
                        @else
                        <td>{{ $row['assigned_id'] }}</td>
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
                </table>
            </font>
        </div>
    </div>
</div>
@endsection
