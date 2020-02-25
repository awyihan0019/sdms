@extends('layouts.app')

@include('project_navbar')

@section('content')
<div class="row" style="margin-left:200px; width:70%">
    <div class="col-md-12">
        <br />
        <h3>Create New Issue </h3>
        <br />

        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
        @endif

        <!-- form start below -->

        <form id="create-issue" method="post" action="{{url('issue')}}">
            {{csrf_field()}}

            <div class="form-group">
                <input type="hidden" name="project_id" value="{{ $project['id'] }}">
            </div>

            <div class="form-group" style="max-width:200px">
                <select type="text" name="type" class="form-control">
                    <option value="" disabled selected>Issue Type</option>
                    <option value="Task">Task</option>
                    <option value="Bug">Bug</option>
                    <option value="Request">Request</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group" style="width:100%">
                <input type="text" name="subject" class="form-control" placeholder="Subject" />
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" cols="40" rows="5" name="description" class="form-control"></textarea>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="description">Priority</label>
                    <select type="text" name="priority" class="form-control">
                        <option value="" disabled selected></option>
                        <option value="high">High</option>
                        <option value="normal">Normal</option>
                        <option value="low">Low</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="description">Severity</label>
                    <select type="text" name="severity" class="form-control">
                        <option value="" disabled selected></option>
                        <option value="high">High</option>
                        <option value="normal">Normal</option>
                        <option value="low">Low</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="description">Category</label>
                    <select type="text" name="category" class="form-control">
                        <option value="" disabled selected></option>
                        <option value="User Interface">User Interface</option>
                        <option value="Functionality">Functionality</option>
                        <option value="Database">Database</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="description">Project Version</label>
                    <input type="text" name="version" class="form-control" />
                </div>
            </div>
            <input form="create-issue" type="submit" class="btn btn-primary pull-right" value="Create New Issue"/>
        </form>


        <!-- form end here -->

    </div>
</div>
@endsection
