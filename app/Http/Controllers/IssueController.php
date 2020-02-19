<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Issue;
use App\Project;
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
        return view('home', compact('issues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id)
    {
        //
        return view('issue.create')->with('project_id', $project_id);
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
            'version'    =>  'required',
            'due_date'    =>  'required'
        ]);
        //创造新variable 并copy 输入的数据
        $user = Auth::user();
        $issue = new Issue([
            'project_id'    =>  $request->get('project_id'),
            'post_user_id'    =>  $user['id'],
            'assigned_user_id'    =>  '1',
            'type'    =>  $request->get('type'),
            'subject'    =>  $request->get('subject'),
            'description'    =>  $request->get('description'),
            'priority'    =>  $request->get('priority'),
            'severity'    =>  $request->get('severity'),
            'category'    =>  $request->get('category'),
            'version'    =>  $request->get('version'),
            'status'    =>  'open',
            'due_date'    =>  $request->get('due_date')
        ]);
        //储存数据
        $issue->save();
        //返回页面
        return view('project.show', ['project' => Project::findOrFail($request->get('project_id'))])->with('success', 'data added');
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
