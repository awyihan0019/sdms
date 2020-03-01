@extends('layouts.project-layout')

@section('project-content')

<div>
    <br />
    <h3>Issue</h3>
    <br />
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{$message}}</p>
    </div>
    @endif
    <table class="table  table-hover">
        <tr>
            <thead class="thead-dark">
                <th style="width:10px">Type</th>
                <th>Subject</th>
                <th style="width:100px">Assignee</th>
                <th style="width:100px">Status</th>
                <th style="width:100px">Priority</th>
                <th style="width:100px">Due Date</th>
            </thead>
        </tr>
        @if ($check = $issues->first() != null)
        @foreach ($issues as $row)
        <tr>
            <td>{{$row['type']}}</td>
            <td><a href="{!! route('issue_show',['project_id'=>$project_id, 'issue_id'=>$row['id']]) !!}">{{$row['subject']}}</a></td>
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
            <td colspan="6">No any issue added</td>
        </tr>
        @endif
    </table>
</div>
@endsection
