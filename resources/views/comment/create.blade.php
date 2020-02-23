@extends('layouts.app')

@include('project_navbar')

@section('content')
<div class="row" style="margin-left:200px; width:70%">
    <div class="col-md-12">
        <br />
        <h3 aling="center">Add New Comment</h3>
        <br />

        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
        @endif

        <form method="post" action="{{url('comment')}}">
            {{csrf_field()}}
            <div class="form-group">
                <textarea type="text" cols="40" rows="5" name="content" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Comment"/>
            </div>
            <div class="form-group">
                <input type="hidden" name="issue_id" value="{{ $issue['id']}}">
            </div>
        </form>
    </div>
</div>
@endsection
