@extends('sample')

@section('content')
<div class="row">
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

  <form method="post" action="{{url('issue')}}">
   {{csrf_field()}}
   <div class="form-group" >
    <select type="text" name="type" class="form-control">
        <option value="" disabled selected>Issue Type</option>
        <option value="task">Task</option>
        <option value="bug">Bug</option>
        <option value="request">Request</option>
        <option value="other">Other</option>
    </select>
   </div>
   <div class="form-group">
    <input type="text" name="subject" class="form-control" placeholder="Subject" />
   </div>
   <div class="form-group">
    <label for="description">Description</label>
    <textarea  type="text" cols="40" rows="5" name="description" class="form-control" ></textarea>
   </div>
   <div class="form-group">
    <select type="text" name="priority" class="form-control" >
        <option value="" disabled selected>Priority</option>
        <option value="high">High</option>
        <option value="normal">Normal</option>
        <option value="low">Low</option>
    </select>
   </div>
   <div class="form-group">
    <select type="text" name="severity" class="form-control" >
        <option value="" disabled selected>Severity</option>
        <option value="high">High</option>
        <option value="normal">Normal</option>
        <option value="low">Low</option>
    </select>
   </div>
   <div class="form-group">
    <input type="text" name="category" class="form-control" placeholder="Category" />
   </div>
   <div class="form-group">
    <input type="text" name="version" class="form-control" placeholder="Project Version" />
   </div>
   <div class="form-group">
    <label for="due_date">Due Date</label>
    <input type="date" name="due_date" class="form-control" placeholder="Due Date" />
   </div>
   <div class="form-group">
    <input type="submit" class="btn btn-primary" />
   </div>
  </form>

    <!-- form end here -->

 </div>
</div>
@endsection
