@extends('layouts.project-layout')

@section('project-content')

<div class="container">
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
    <div>
        <h1>Project Home :</h1>
    </div>
    <canvas id="myChart" style="max-width: 500px;"></canvas>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xl-10">
            <div class="card">
                <div class="card-header"><a data-toggle="collapse" data-target="#show_histories" aria-expanded="false"
                        aria-controls="collapseOne">Dashboard<i class="fas fa-chevron-down fa-fw"></i></div>
            </div>
            <div id="show_histories" class="collapse in show">
                @if ($histories->first() != null)
                @foreach ($histories as $row)
                <div class="card bg-light mb-3">
                    <div class="card-header">{{ $row['created_at'] }}</div>
                    <div class="card-body">
                        <p class="card-text">{!! $row['action_log'] !!}</p>
                    </div>
                </div>
                @endforeach
                @else
                <p>No history found</p>
                @endif
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xl-1">
            <div class="card" style="width: 10rem;">
                <div class="card-header">Member</div>
                <ul class="list-group list-group-flush">
                    @if ($users->first() != null)
                    @foreach($users ?? '' as $row)
                    <li class="list-group-item">{{$row['name']}}</li>
                    @endforeach
                    @else
                    <li class="list-group-item">No any user found</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
        }]
        },
        options: {
        scales: {
        yAxes: [{
        ticks: {
        beginAtZero: true
        }
        }]
        }
        }
        });
</script>
@endsection
