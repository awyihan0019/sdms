@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <a href="{{action('ProjectController@create')}}" class="btn btn-warning">Add Project</a>

                <div class="card-header" >Projects </div>
                @if (isset($projects))
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                            @foreach($projects ?? '' as $row)
                            <tr>
                            <td><a href="{{action('ProjectController@show', $row['id'])}}">{{$row['project_name']}}</a></td>
                            <td></td>
                            </tr>
                            @endforeach
                    </table>
                </div>
                @endif
            </div>
            <div class="card">

                <div class="card-header">My Issues</div>
                @if (isset($issues))
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                         <th style="width:20px;text-align: center;">ID</th>
                         <th>Subject</th>
                         <th style="width:40px">Priority</th>
                         <th style="width:40px">Status</th>
                         <th style="width:40px">Due</th>
                        </tr>
                        @foreach($issues as $row)
                        <tr>
                            <td>{{$row['id']}}</td>
                            <td>{{$row['subject']}}</td>
                            <td>{{$row['priority']}}</td>
                            <td>{{$row['status']}}</td>
                            <td>{{$row['due_date']}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
    </div>
</div>
@endsection
