@extends('sample')

@section('content')

<div class="row">
    <div class="col-md-12">
        <br />
        <h3 align="center">Issue Data</h3>
        <br />
        @if($message = Session::get('success'))
        <div class="alert alert-success">
        <p>{{$message}}</p>
        </div>
        @endif
        <div align="right">
            <a href="{{route('issue.create')}}" class="btn btn-primary">
            Add
            </a>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>Task</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Severity</th>
                <th>Catogory</th>
                <th>Project Version</th>
                <th>Due Date</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach ($issue as $row)
                <tr>
                    <td>{{$row['subject']}}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
