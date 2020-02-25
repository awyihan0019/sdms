<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DB;
use App\Issue;
use App\Project;
use App\History;


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

        $projects = $user->projects()->get();

        $assignedIssues = $user->AssignedIssue()->get();
        $postedIssues = $user->postedIssue()->get();
        $issues = $assignedIssues->merge($postedIssues); //here have some problem fix

        $histories = $user->histories()->get()->sortByDesc('created_at');
        return view('/home', [
            'projects' => $projects,
            'issues' => $issues,
            'histories' => $histories]);
    }
}
