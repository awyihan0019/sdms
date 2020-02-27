<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\User;
use App\History;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;

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
             $project_id = Route::current()->parameters['project_id'];
             $user_role = $this->user->projects()->get()->where('id', $project_id)->first()->pivot->role;
             $this->user->syncRoles($user_role);
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
            'project_name'    =>  'required',
        ]);
        //创造新variable 并copy 输入的数据
        $project = new Project([
            'project_name'    =>  $request->get('project_name'),
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
        $action_log = "$user_name <span class=\"badge badge-success\">Create</span> a project $project_name";

        $history = new History([
            'user_id'   =>  $user['id'],
            'project_id'    => $project['id'],
            'action_log'    =>  $action_log
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


        // return view('project.show', compact('project', 'project_id', 'users', 'histories'));
        //
        //,['project_id' => $project_id]
        return view('project.show', compact('project_id','project_name', 'users', 'histories'));
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
            'project_name'    =>  'required'
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

    public function storeMember(Request $request, $project_id)
    {
        // //创造新variable 并copy 输入的数据
        $email = $request->input('email');
        $project_id = $request->input('project_id');

        // //储存数据
        $user = User::where('email',$email) -> first();
        if(empty($user)){
            return redirect()->back()->with('error', 'The email not found in used');
        }else{
            $project = Project::findOrFail($project_id);

            $project_members = $project->users()->get()->toArray();

            foreach($project_members as $member){
                if($member['email'] == $email){
                    return redirect()->back()->with('error', 'The member is already added');
                }
            }

            $user->projects()->attach($project);
            $user->projects()->updateExistingPivot($project, ['role' => $request->input('role')]);
            //add history
            $user_name = $user['name'];
            $project_name = $project['project_name'];

            $action_log = "$project_name has been <span class=\"badge badge-success\">Invite</span> a new member $user_name";

            $history = new History([
                'user_id'   =>  $user['id'],
                'project_id'    => $project['id'],
                'action_log'    =>  $action_log
            ]);

            $history->save();
        }
        //返回页面
        return redirect()->action('ProjectController@show', $project_id);;
    }
}
