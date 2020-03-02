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

        $assignedIssues = $user->AssignedIssue()->whereIn('status',['Open','In Progress'])->get();
        $postedIssues = $user->postedIssue()->whereIn('status',['Open','In Progress'])->get();
        $issues = $assignedIssues->merge($postedIssues);

        //get history
        $projects = $user->projects()->get();
        $histories = $user->histories()->get()->sortByDesc('created_at');
        foreach($projects as $p){
            $historyForProject = $p->histories()->get();
            $histories = $histories->merge($historyForProject)->sortByDesc('created_at');
        }

        return view('/home', [
            'projects' => $projects,
            'issues' => $issues,
            'assignedIssues' => $assignedIssues,
            'postedIssues' => $postedIssues,
            'histories' => $histories]);
    }
}
