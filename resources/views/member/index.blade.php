@extends('layouts.project-layout')

@section('project-content')
{{-- // problem : not in used --}}
<div>
    <br />
    <h3>Member</h3>
    <br />
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{$message}}</p>
    </div>
    @endif
    <table class="table  table-hover">
        <tr>
            <thead class="thead-dark">
                <th style="width:10px">Name</th>
                <th style="width:100px">Role</th>
                <th style="width:100px">Status</th>
            </thead>
        </tr>
        @if ($check = $members->first() != null)
        @foreach ($members as $row)
        <tr>
            <td>{{$row['name']}}</td>
            <td>{{$row->projects()->get()->where('id', $project_id)->first()->pivot->role}}</td>
            {{-- <td><a href="{!! route('issue_show',['issue_id'=>$row['id']]) !!}">{{$row['subject']}}</a></td> --}}
            <td>{{ $row['due_date'] }}</td>
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
