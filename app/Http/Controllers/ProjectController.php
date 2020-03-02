<?php

namespace App\Http\Controllers;

use App\Charts\ProgressChart;
use App\History;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            if (empty(Route::current()->parameters['project_id'])) {
                // dd(Route::current()->uri);
            } else {
                $project_id = Route::current()->parameters['project_id'];

                $user_role = $this->user->projects()->get()->where('id', $project_id)->first()->pivot->role;
                $this->user->syncRoles($user_role);
            }

            return $next($request);
        });

        $this->middleware('permission:invite_member', ['only' => ['storeMember']]);
    }

    public function index()
    {
        // problem: need to do for showing all the project and allow to add them to user
        $user = Auth::user();
        $projects = $user->projects()->get()->toArray();
        return view('home', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //确认输入所需数据 validate the data input
        $this->validate($request, [
            'project_name' => 'required',
        ]);
        //创造新variable 并copy 输入的数据
        $project = new Project([
            'project_name' => $request->get('project_name'),
        ]);
        //储存数据
        $user = Auth::user();

        $user->projects()->save($project, ['role' => 'Manager']);
        // $project->save();
        // $user->projects()->attach($project);
        // $user->projects()->updateExistingPivot($project, ['role_id' => 1]);

        //create histories
        $user_name = $user['name'];
        $project_name = $project['project_name'];
        $action_log = "<Strong>$user_name</Strong> <span class=\"badge badge-success\">Create</span> a project <strong>$project_name</strong>";

        $history = new History([
            'user_id' => $user['id'],
            'project_id' => $project['id'],
            'action_log' => $action_log,
        ]);

        $history->save();

        //返回页面
        return redirect('/home')->with('success', 'Data Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($project_id)
    {
        //
        //find current project
        $project = Project::find($project_id);

        $project_name = $project->project_name;

        //get project members
        $users = $project->users()->get();

        //get all histories for project
        $histories = $project->histories()->get()->sortByDesc('created_at');

        //get all issue count
        // dd($project->issues()->whereIn('status',['Open','In Progress'])->get()->count());
        $closedIssues = $project->issues()->get()->count();
        $openIssues = $project->issues()->where('status', 'Open')->get()->count();
        $progressIssues = $project->issues()->where('status', 'In Progress')->get()->count();
        $closedIssues = $project->issues()->where('status', 'Closed')->get()->count();
        $resolvedIssues = $project->issues()->where('status', 'Resolved')->get()->count();

        //create progress chart
        $progressChart = new ProgressChart;
        $progressChart->displayAxes(false);
        $progressChart->labels(['Open', 'In Progress', 'Resolved', 'Closed']);
        $progressChart->dataset('Progress by Issue Status', 'doughnut', [$openIssues, $progressIssues, $resolvedIssues, $closedIssues])->backgroundColor(['#ed8077','#4488c5','#5eb5a6','#b0be3c']);

        //get all issue count by catogory
        $uiIssuesO = $project->issues()->where('category', 'User Interface')->where('status', 'Open')->get()->count();
        $funcIssuesO = $project->issues()->where('category', 'Functionality')->where('status', 'Open')->get()->count();
        $dbIssuesO = $project->issues()->where('category', 'Database')->where('status', 'Open')->get()->count();
        $uiIssuesIP = $project->issues()->where('category', 'User Interface')->where('status', 'In Progress')->get()->count();
        $funcIssuesIP = $project->issues()->where('category', 'Functionality')->where('status', 'In Progress')->get()->count();
        $dbIssuesIP = $project->issues()->where('category', 'Database')->where('status', 'In Progress')->get()->count();

        //create catogory progress chart
        $categoryChart = new ProgressChart;
        $categoryChart->labels(['User Interface', 'Functionality', 'Database']);
        $categoryChart->dataset('Open', 'bar', [$uiIssuesO, $funcIssuesO, $dbIssuesO])->backgroundColor(['#ed8077', '#ed8077', '#ed8077'])->color('black');
        $categoryChart->dataset('In Progress', 'bar', [$uiIssuesIP, $funcIssuesIP, $dbIssuesIP])->backgroundColor(['#4488c5', '#4488c5', '#4488c5'])->color('black');

        return view('project.show', compact('project_id', 'project_name', 'users', 'histories', 'progressChart', 'categoryChart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id)
    {
        //
        $project = Project::find($project_id);

        return view('project.edit', compact('project', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id)
    {
        //
        $this->validate($request, [
            'project_name' => 'required',
        ]);
        $project = Project::find($project_id);
        $project->project_name = $request->get('project_name');
        $project->save();
        return redirect('/home')->with('success', 'Data Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id)
    {
        //
        $project = Project::find($project_id);
        $project->delete();
        return redirect()->route('/home')->with('success', 'Data Deleted');
    }

    public function showMember($project_id)
    {
        //find current project
        $project = Project::find($project_id);
        //get project members
        $members = $project->users()->get();

        $project_name = $project['project_name'];

        return view('member.index', compact('project_id', 'project_name', 'members'));
    }

    public function storeMember(Request $request, $project_id)
    {
        // //创造新variable 并copy 输入的数据
        $email = $request->input('email');
        $project_id = $request->input('project_id');

        // //储存数据
        $user = User::where('email', $email)->first();

        if (empty($user)) {
            return redirect()->back()->withErrors(array('message' => 'The email not found in used'));
        } else {
            $project = Project::findOrFail($project_id);

            $project_members = $project->users()->get()->toArray();

            foreach ($project_members as $member) {
                if ($member['email'] == $email) {
                    return redirect()->back()->withErrors(array('message' => 'The member is already added'));
                }
            }

            //add user to project
            $user->projects()->attach($project);
            //with role
            $user->projects()->updateExistingPivot($project, ['role' => $request->input('role')]);


            //add history
            $user_name = $user['name'];
            $project_name = $project['project_name'];

            $action_log = "<strong>$project_name</strong> has been <span class=\"badge badge-success\">Invite</span> a new member <strong>$user_name</strong>";

            $history = new History([
                'user_id' => $user['id'],
                'project_id' => $project['id'],
                'action_log' => $action_log,
            ]);

            $history->save();

            //email invitee
            if($request->get('mail_to_invitee') == "true"){
                Mail::to($user)->send(new UpdateHistory());
            }
        }
        //返回页面
        return redirect()->action('ProjectController@showMember', $project_id);
    }
}
