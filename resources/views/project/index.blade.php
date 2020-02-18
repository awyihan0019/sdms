@extends('sample')

@section('content')

<div class="row">
    <div class="col-md-12">
        <br />
        <h3 align="center">Project List</h3>
        <br />
        @if($message = Session::get('success'))
        <div class="alert alert-success">
        <p>{{$message}}</p>
        </div>
        @endif
        <div align="right">
            <a href="{{route('project.create')}}" class="btn btn-primary">
            Add
            </a>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>Project Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach ($project as $row)
                <tr>
                    <td>{{$row['project_name']}}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
