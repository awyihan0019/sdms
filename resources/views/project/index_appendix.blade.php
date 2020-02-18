@extends('sample')

@section('content')

<div class="row">
 <div class="col-md-12">
  <br />
  <h3 align="center">project Data</h3>
  <br />
  @if($message = Session::get('success'))
  <div class="alert alert-success">
   <p>{{$message}}</p>
  </div>
  @endif
  <div align="right">
   <a href="{{route('project.create')}}" class="btn btn-primary">Add</a>
   <br />
   <br />
  </div>
  <table class="table table-bordered table-striped">
   <tr>
    <th>Project Name</th>
    <th>Edit</th>
    <th>Delete</th>
   </tr>
   @foreach($projects as $row)
   <tr>
    <td>{{$row['project_name']}}</td>
    {{-- <td><a href="{{action('ProjectController@edit', $row['id'])}}" class="btn btn-warning">Edit</a></td> --}}
    <td></td>
   </tr>
   @endforeach
  </table>
 </div>
</div>

@endsection
