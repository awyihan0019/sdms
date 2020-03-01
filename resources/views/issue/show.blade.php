@extends('layouts.project-layout')

@section('project-content')
<div class="row">
    <div class="col-md-12">
        <br />
        <h3>Issue #{{ $issue['id']}}
            @can('edit_issues')
            <a href="{{route('issue_edit', ['project_id'=>$project_id, 'issue_id'=>$issue['id']])}}"
                class="btn btn-secondary float-right" style="margin-righr:20px">
                <i class="fas fa-edit">Edit Issue</i>
            </a>
            @endcan
        </h3>
        <br />
        <table class="table">
            <tr>
                <th><strong> Issue Type </strong></th>
                <td> {{ $issue['type'] }} </td>
                <th style="width:10px"><strong> Status </strong></th>
                <td> {{ $issue['status'] }} </td>
            </tr>
            <tr>
                <th><strong> Subject </strong></th>
                <td colspan="3"> {{ $issue['subject'] }} </td>
            </tr>
            <tr>
                <th><strong> Description </strong></th>
                <td colspan="3"> {!! nl2br(e($issue['description'])) !!} </td>
            </tr>
            <tr>
                <th><strong> Priority </strong></th>
                @if ($issue['priority'] == "high")
                <td class="text-danger">High</td>
                @elseif($issue['priority'] == "normal")
                <td class="text-primary">Normal</td>
                @elseif($issue['priority'] == "low")
                <td class="text-success">Low</td>
                @endif
                <th><strong> Severity </strong></th>
                @if ($issue['severity'] == "high")
                <td class="text-danger">High</td>
                @elseif($issue['severity'] == "normal")
                <td class="text-primary">Normal</td>
                @elseif($issue['severity'] == "low")
                <td class="text-success">Low</td>
                @endif
            </tr>
            <tr>
                <th><strong> Category </strong></th>
                @if ($issue['category'] == 'User Interface')
                <td>User Interface</td>
                @elseif($issue['category'] == 'Functionality')
                <td>Functionality</td>
                @elseif($issue['category'] == 'Database')
                <td>Database</td>
                @endif
                <th><strong> Project Version </strong></th>
                <td> {{ $issue['version'] }} </td>
            </tr>
            <tr>
                <th><strong> Due Date </strong></th>
                @if (empty($issue['due_date']))
                <td> Not set </td>
                @else
                <td> {{ $issue['due_date'] }} </td>
                @endif
                <th><strong> Assignee </strong></th>
                @if (empty($issue['assigned_user_id']))
                <td> Not set </td>
                @else
                <td> {{ $issue->assignedUser()->first()['name'] }} </td>
                @endif
            </tr>
        </table>
        @error('attchFile')
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Upload Failed !</strong> {{ $message }}
        </div>
        @enderror
        <div class="card">
            <div class="card-header">
                <a data-toggle="collapse" data-target="#show_attached_file" aria-expanded="false"
                    aria-controls="collapseOne">
                    Attached File
                    <i class="fas fa-chevron-down fa-fw"></i>
                </a>
                @can('attach_file')
                <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#attach_new_file">
                    <i class="fas fa-paperclip">Attach New File</i>
                </button>
                @endcan
            </div>
        </div>
        <!-- Modal -->
        <div class="modal" id="attach_new_file" tabindex="-1" role="dialog" aria-labelledby="attach_new_fileLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attach_new_fileLabel">Attachment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="attach_file" method="post"
                            action="{{action('IssueController@attachFile',[$project_id ,$issue['id']])}}"
                            enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="attchFile">Select a file to upload (File size not larger than 5mb)</label>
                                <input type="file" name="attchFile" class="form-control-file">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <input form="attach_file" type="submit" class="btn btn-primary" aglin="right"
                            value="Upload File" />
                    </div>
                </div>
            </div>
        </div>
        <div id="show_attached_file" class="collapse in show">
            <table class="table">
                <tr>
                    <thead>
                        <th>File Name</th>
                        <th style="width:150px">Attach By</th>
                        <th style="width:150px">Upload Time</th>
                    </thead>
                </tr>
                @if ($check = $attached_file->first() != null)
                @foreach ($attached_file as $row)
                <tr>
                    <td><a href="{{ route('attachment.download', $row->id) }}">{{$row['file_name']}}</a></td>
                    <td>{{$row->uploaded_user()->first()['name']}}</td>
                    <td>{{$row['created_at']}}</td>
                </tr>
                @endforeach
                @else
                <td>No attached any file</td>
                @endif
            </table>
        </div>
    </div>
</div>
<hr>
<div class="col-md-12">
    <h3 class="reviews">Comment
        <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#comment_issue"><i
                class="fas fa-comment-dots">Add Comment</i></button>
    </h3>
    {{--  --}}
    @error('comment')
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Comment Failed !</strong> {{ $message }}
    </div>
    @enderror
    {{--  --}}

    <!-- Modal -->
    <div class="modal" id="comment_issue" tabindex="-1" role="dialog" aria-labelledby="comment_issueLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="comment_issueLabel">Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="comment" method="post" action="{{url('comment')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea type="text" cols="40" rows="5" name="content" class="form-control"
                                placeholder="Leave a comment"></textarea>
                        </div>
                        <div class="form-group">
                            @if (empty($issue['assigned_user_id']) != true)
                            <input type="checkbox" id="mail_to_assignee" name="mail_to_assignee" value="true">
                            <label for="mail_to_assignee"> Send an email to the Assignee :
                                <strong>{{ $issue->assignedUser()->first()['name'] }}</strong></label><br>
                            @endif
                            @if (empty($issue['post_user_id']) != true)
                            <input type="checkbox" id="mail_to_publisher" name="mail_to_publisher" value="true">
                            <label for="mail_to_publisher"> Send an email to the Publisher :
                                <strong>{{ $issue->postedUser()->first()['name'] }}</strong></label><br>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="issue_id" value="{{ $issue['id']}}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input form="comment" type="submit" class="btn btn-primary" aglin="right" value="Comment" />
                </div>
            </div>
        </div>
    </div>

    {{--  --}}
    {{--  --}}
    <br>
    @if ($comments->first() != null)
    @foreach($comments ?? '' as $row)
    <div class="card">
        <div class="card-body">
            <div>
                <h5 class="card-title">{{ $row->commented_user()->first()['name'] }}</h5>
                <p class="card-text">{{$row['content']}}</p>
            </div>
        </div>
        <div class="card-footer text-muted">{{$row['created_at']}}</div>
    </div>
    @endforeach
    @else
    <div class="card">
        <div class="card-body">
            <div>
                <p class="card-text">No any comment found.</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
