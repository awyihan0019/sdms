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
                <th>ID</th>
                <th>Subject</th>
                <th style="width:100px">Current Priority</th>
                <th style="width:100px">Suggested Priority</th>
                <th>Predicted Level</th>
                <th>Reason</th>
                <th style="width:100px">Update Priority</th>
            </thead>
        </tr>
        @if ($suggested_issues->isNotEmpty())
        @foreach ($suggested_issues as $row)
        @php
        @endphp
        @if ($row != null)
        <tr>
            <td>{{$row['type']}}</td>
            <td><a
                    href="{!! route('issue_show',['project_id'=>$project_id, 'issue_id'=>$row['id']]) !!}">{{$row['subject']}}</a>
            </td>
            @if ($row['priority'] == "high")
            <td class="text-danger">High</td>
            @elseif($row['priority'] == "normal")
            <td class="text-primary">Normal</td>
            @elseif($row['priority'] == "low")
            <td class="text-success">Low</td>
            @endif
            @if ($row['suggested_priority'] == "high")
            <td class="text-danger">High</td>
            @elseif($row['suggested_priority'] == "normal")
            <td class="text-primary">Normal</td>
            @elseif($row['suggested_priority'] == "low")
            <td class="text-success">Low</td>
            @endif
            <td>{!! $row['priority_level'] !!}</td>
            <td>{!! $row['reason'] !!}</td>
            <td><form id={{ $row['id'] }} method="post"
                action="{{action('IssueController@updatePriority',[$project_id ,$row['id']])}}">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH" />
                <input type="hidden" name="suggested_priority" value="{{ $row['suggested_priority']}}">
                <input form={{ $row['id'] }} type="submit" class="btn btn-primary" value="Update" />
            </form></td>
        </tr>
        @endif
        @endforeach
        @else
        <tr>
            <td colspan="6">No any issue need to change priority</td>
        </tr>
        @endif
    </table>
</div>
@endsection
