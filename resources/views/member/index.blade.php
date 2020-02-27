@extends('layouts.app')

@include('project_navbar')

@section('content')
// problem : not in used
<div style="margin-left:200px;width:70%">
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
            <td>{{$row->projects()}}</td>
            {{-- <td><a href="{!! route('issue_show',['issue_id'=>$row['id']]) !!}">{{$row['subject']}}</a></td> --}}
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
