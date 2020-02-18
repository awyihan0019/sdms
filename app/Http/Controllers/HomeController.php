<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DB;
use App\Issue;
use App\Project;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $projects = DB::table('projects')->get()->toArray();
        $projects = $user->projects()->get()->toArray();

        $issues = DB::table('issues')->get()->toArray();
        $issues = $user->AssignedIssue()->get()->toArray();

        return view('/home', [
            'projects' => $projects,
            'issues' => $issues]);
    }
}
