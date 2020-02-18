@extends('layouts.app')
@extends('sample')




@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <!--You are logged in! -->
                </div>
            </div>
        </div>
    </div>
    <div class="real content">
        <button onclick="location.href = '../project/create'" type="button" class="btn btn-default">Project</button>
        <button onclick="location.href = '../issue/create'" type="button" class="btn btn-default">Issue</button>
        @php
            $user = Auth::user();
        @endphp
        <a>{{  $user->name  }}</a>
    </div>
</div>
@endsection
