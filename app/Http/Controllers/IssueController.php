<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\UpdateHistory;
use Illuminate\Support\Facades\Mail;

use App\Issue;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_id)
    {
        //
        $project = Project::find($project_id);
        $issues = $project->issues()->get()->toArray();
        return view('issue.index', compact('issues', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id)
    {
        //
        $project = Project::find($project_id);
        return view('project.create_issue')->with('project', $project);
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
            'project_id' => 'required',
            'type'    =>  'required',
            'subject'    =>  'required',
            'description'    =>  'required',
            'priority'    =>  'required',
            'severity'    =>  'required',
            'category'    =>  'required',
            'version'    =>  'required'
        ]);
        //创造新variable 并copy 输入的数据
        $user = Auth::user();
        $issue = new Issue([
            'project_id'    =>  $request->get('project_id'),
            'post_user_id'    =>  $user['id'],
            'type'    =>  $request->get('type'),
            'subject'    =>  $request->get('subject'),
            'description'    =>  $request->get('description'),
            'priority'    =>  $request->get('priority'),
            'severity'    =>  $request->get('severity'),
            'category'    =>  $request->get('category'),
            'version'    =>  $request->get('version'),
            'status'    =>  'open'
        ]);
        //储存数据
        $issue->save();
        $project = Project::findOrFail($request->get('project_id'));
        $issues = $project->issues()->get()->toArray();
        //返回页面
        return view('issue.index', ['project' => Project::findOrFail($request->get('project_id'))])->with('issues', $issues);
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
        $issue = Issue::find($id);
        $project = $issue->project()->get()->first();
        $comments = $issue->comments()->get();
        $users = $project->users()->get()->toArray(); //using for show assignee
        $project_members = $project->users()->get()->toArray();
        return view('issue.edit', ['issue' => Issue::findOrFail($id)], compact('issue', 'id', 'project','project_members', 'users', 'comments'));
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
        $this->validate($request, [
            'type'    =>  'required',
            'subject'    =>  'required',
            'description'    =>  'required',
            'priority'    =>  'required',
            'severity'    =>  'required',
            'category'    =>  'required',
            'version'    =>  'required',
            'status'    =>  'required'
        ]);

        $issue = Issue::find($id);

        $issue->type = $request->get('type');
        $issue->subject = $request->get('subject');
        $issue->description = $request->get('description');
        $issue->priority = $request->get('priority');
        $issue->severity = $request->get('severity');
        $issue->category = $request->get('category');
        $issue->version = $request->get('version');
        $issue->due_date = $request->get('due_date');
        $issue->assigned_user_id = $request->get('assigned_user_id');
        $issue->status = $request->get('status');

        $issue->save();

        Mail::to($request->user())->send(new UpdateHistory());

        return redirect('/home')->with('success', 'Data Updated');
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
