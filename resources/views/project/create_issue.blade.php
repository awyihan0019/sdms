@extends('layouts.app')

@include('project_navbar')

@section('content')
<div class="row" style="margin-left:200px" align="left">
    <div class="col-md-12">
        <br />
        <h3 aling="center">Create New Issue</h3>
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
        <div class="container py-5" >
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <form method="post" action="{{url('issue')}}" >
                        {{csrf_field()}}
                        <div class="form-group" style="max-width:200px">
                            <select type="text" name="type" class="form-control">
                                <option value="" disabled selected>Issue Type</option>
                                <option value="task">Task</option>
                                <option value="bug">Bug</option>
                                <option value="request">Request</option>
                                <option value="other">Other</option>
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
                                    <option value="normal">User Interface</option>
                                    <option value="low">Functionality</option>
                                    <option value="high">Database</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="description">Project Version</label>
                                <input type="text" name="version" class="form-control" />
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" name="due_date" class="form-control" />
                        </div> --}}
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" />
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="project_id" value="{{ $project['id'] }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- form end here -->

    </div>
</div>
@endsection
