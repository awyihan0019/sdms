@extends('layouts.project-layout')

@section('project-content')
<div>
    @can('invite_member')
    <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#invite_user"
        style="margin-top:10px;"><i class="fas fa-user-plus"> Invite User</i></button>
    @endcan
    <!-- Modal -->
    <div class="modal" id="invite_user" tabindex="-1" role="dialog" aria-labelledby="invite_userLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invite_userLabel">Invite User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="storeMember" method="post"
                        action="{{action('ProjectController@storeMember', $project_id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="attchFile">E-mail </label>
                            <input type="email" name="email" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="description">Role</label>
                            <select type="text" name="role" class="form-control">
                                <option value="Manager">Manager</option>
                                <option value="Tester">Tester</option>
                                <option value="Programmer">Programmer</option>
                            </select>
                        </div>
                        <input type="checkbox" id="mail_to_invitee" name="mail_to_invitee" value="true">
                            <label for="mail_to_invitee"> Send an email to the Invitee</label>
                        <div class="form-group">
                            <input type="hidden" name="project_id" value="{{ $project_id }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input form="storeMember" type="submit" class="btn btn-primary" aglin="right" value="Invite User" />
                </div>
            </div>
        </div>
    </div>
    <br />
    <h3>Member</h3>
    <br />
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{$message}}</p>
    </div>
    @endif
    @error('message')
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Invite Failed !</strong> {{ $message }}
    </div>
    @enderror
    <table class="table  table-hover">
        <tr>
            <thead class="thead-dark">
                <th style="width:10px">Name</th>
                <th style="width:100px">Role</th>
                <th style="width:100px">Status</th>
            </thead>
        </tr>
        @if ($check = $members->first() != null)
        @foreach ($members as $row)
        <tr>
            <td>{{$row['name']}}</td>
            <td>{{$row->projects()->get()->where('id', $project_id)->first()->pivot->role}}</td>
            {{-- <td><a href="{!! route('issue_show',['issue_id'=>$row['id']]) !!}">{{$row['subject']}}</a></td> --}}
            <td>{{ $row['due_date'] }}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="6">No any issue added</td>
        </tr>
        @endif
    </table>
</div>
@endsection
