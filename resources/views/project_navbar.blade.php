<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="{{ asset('css/master.css')}}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="w3-sidebar w3-bar-block" style="width:10%;min-width: 150px;background-color: #009688;" >
    <h3 class="w3-bar-item" >Menu</h3>
    {{-- <a href="{{action('ProjectController@show', $project_id)}}"" class="w3-bar-item w3-button current"><i class="fa fa-home"></i> Project</a> --}}
    <a href="{{route('currentProject', ['project_id'=>$project_id])}}" class="w3-bar-item w3-button current"><i class="fa fa-home"></i> Project</a>
    <a href="{{route('issue_index', ['project_id'=>$project_id])}}" class="w3-bar-item w3-button current"><i class="fas fa-tasks"></i> Issues</a>
    @can('create_issues')
    <a href="{{route('issue_create', ['project_id'=>$project_id])}}" class="w3-bar-item w3-button current"><i class="fas fa-plus"></i> Add Issue</a>
    @endcan
    <a href="{{route('priority_control', ['project_id'=>$project_id])}}" class="w3-bar-item w3-button current"><i class="fas fa-plus"></i> Priority Control</a>
</div>
