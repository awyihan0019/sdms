<?php

namespace App\Http\Controllers;

use App\Comment;
use App\History;
use App\Issue;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public $user;

    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware(function ($request, $next) {
        //     $this->user = Auth::user();

        //     $project_id = Route::current()->parameters['project_id'];
        //     $user_role = $this->user->projects()->get()->where('id', $project_id)->first()->pivot->role;
        //     $this->user->syncRoles($user_role);
        //     return $next($request);
        // });
        $this->middleware('permission:comment_issues', ['only' => ['create', 'store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        // $issue = Issue::find($id);
        // $comments = $issue->comments()->get()->toArray();
        // return view('project.show', ['project' => Project::findOrFail($id)], compact('project', 'id', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id, $issue_id)
    {
        //
        $issue = Issue::find($issue_id);
        $project = Project::find($project_id);
        return view('comment.create', compact('issue', 'project'));
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
        $this->validate($request, [
            'content' => 'required',
        ]);
        //创造新variable 并copy 输入的数据
        $user = Auth::user();
        $comment = new Comment([
            'content' => $request->get('content'),
            'comment_user_id' => $user['id'],
            'issue_id' => $request->get('issue_id'),
        ]);
        //储存数据

        $comment->save();

        //create history
        $user_name = $user['name'];
        $issue = $comment->issue();
        $current_issue = $issue->get()->first();
        $issue_toArray = $current_issue->toArray();
        $project = $current_issue->project();
        $current_project = $project->get()->first();
        $project_toArray = $current_project->toArray();
        $project_name = $current_project['project_name'];
        $issue_id = $issue_toArray['id'];

        $action_log = "$user_name had been <span class=\"badge badge-success\">Comment</span> to issue $issue_id in $project_name";

        $history = new History([
            'user_id' => $user['id'],
            'project_id' => $project_toArray['id'],
            'issue_id' => $issue_toArray['id'],
            'comment_id' => $comment['id'],
            'action_log' => $action_log,
        ]);

        $history->save();

        //返回页面
        return redirect()->route('issue_show', ['project_id' => $project_toArray['id'], 'issue_id' => $issue_toArray['id']])->with('success', 'Data Updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}