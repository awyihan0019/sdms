@extends('layouts.project-layout')

@section('project-content')

<div class="container">
    <div>
        <br>
        <h1>Project Home :</h1>
        <br>
    </div>
    <div class="row d-block clearfix">
        <div class="col-md-12 col-sm-12 col-xl-8 float-left">
            <div class="card">
                <div class="card-header"><a data-toggle="collapse" data-target="#show_histories" aria-expanded="false"
                        aria-controls="collapseOne">Dashboard<i class="fas fa-chevron-down fa-fw"></i></a></div>
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
        <div class="col-md-12 col-sm-12 col-xl-4 float-right">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <a data-toggle="collapse" data-target="#show_chart" aria-expanded="false"
                                aria-controls="collapseOne">Status
                                <i class="fas fa-chevron-down fa-fw"></i>
                            </a>
                        </div>
                    </div>
                    <div id="show_chart" class="collapse in show"
                        style="border-left: 6px solid red;background-color: lightgrey;">
                        <div>
                            {!! $progressChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:10px">
                <div class="col-md-12 col-sm-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <a data-toggle="collapse" data-target="#show_category_chart" aria-expanded="false"
                                aria-controls="collapseOne">Category
                                <i class="fas fa-chevron-down fa-fw"></i>
                            </a>
                        </div>
                    </div>
                    <div id="show_category_chart" class="collapse in show"
                        style="border-left: 6px solid blue;background-color: lightgrey;">
                        <div>
                            {!! $categoryChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! $progressChart->script() !!}
{!! $categoryChart->script() !!}
@endsection
