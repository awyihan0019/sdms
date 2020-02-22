@extends('layouts.app')

@include('project_navbar')

@section('content')

<div class="container" style="margin-left:150px">
    <a href="{{route('add_member', ['project_id'=>$project['id']])}}" class="btn btn-warning float-right" align="right">Add Member</a>
    <div>
        <h1>{{$project['project_name']}}</h1>
    </div>
    <div class="card">
        <div class="card-header">Member</div>
        @if (empty($users))
        <div class="card-body">
            <div>No any user found</div>
        </div>
        @else
        <div class="card-body">
            <table class="table table-bordered table-striped">
                @foreach($users ?? '' as $row)
                <tr>
                    <td>{{$row['name']}}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        @endif
    </div>
@endsection
