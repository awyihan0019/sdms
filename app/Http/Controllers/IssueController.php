<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\UpdateHistory;
use Illuminate\Support\Facades\Mail;

use App\Issue;
use App\Project;
use App\User;
use App\History;
use App\Attachment;
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
        $issues = $project->issues()->get();
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

        //valite input data
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
            'status'    =>  'Open'
        ]);
        //储存数据
        $issue->save();
        $project = Project::findOrFail($request->get('project_id'));
        $issues = $project->issues()->get();

        //create history
        $user_name = $user['name'];
        $project_name = $project['project_name'];
        $issue_id = $issue['id'];

        $action_log = "$user_name add a new issue $issue_id for $project_name";

        $history = new History([
            'user_id'   =>  $user['id'],
            'project_id'    => $project['id'],
            'issue_id'    => $issue['id'],
            'action_log'    =>  $action_log
        ]);

        $history->save();

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
        $issue = Issue::find($id);
        $project = $issue->project()->get();
        $comments = $issue->comments()->get();
        $attached_file = $issue->attachments()->get();
        return view('issue.show', compact('project', 'comments', 'issue', 'attached_file'));

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
        $project = $issue->project();
        $issue_project = $project->get()->first();
        $project_id = $issue_project['id'];
        $comments = $issue->comments()->get();
        $project_members = $issue_project->users()->get()->toArray();

        return view('issue.edit', ['issue' => Issue::findOrFail($id)], compact('issue', 'id', 'project', 'project_id','project_members', 'comments'));
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

        $user = Auth::user();

        //validate input data
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

        //email notification
        Mail::to($request->user())->send(new UpdateHistory());

        //create history
        $user_name = $user['name'];
        $project = $issue->project()->get()->first();
        $project_name = $project['project_name'];
        $issue_id = $issue['id'];

        $action_log = "$user_name had been edited issue $issue_id in $project_name";

        $history = new History([
            'user_id'   =>  $user['id'],
            'project_id'    => $project['id'],
            'issue_id'    => $issue['id'],
            'action_log'    =>  $action_log
        ]);

        $history->save();

        return redirect()->route('issue_show', ['issue_id'=>$issue['id']])->with('success', 'Data Updated');
    }

    public function attachFile(Request $request, $id)
    {
        $this->validate($request, [
            'attchFile'    =>  'required|file|max:5000'
        ]);

        $user = Auth::user();
        $issue = Issue::find($id);

        $uploadedFile = $request->file('attchFile');
        $fileName = $uploadedFile->getClientOriginalName();
        $uploadedFile->move('uploaded_file', $fileName);

        $attachment = new Attachment([
            'uploaded_user_id'    =>  $user['id'],
            'attached_issue_id'    =>  $issue['id'],
            'attached_file'    =>  $fileName
        ]);

        $attachment->save();

        return redirect()->route('issue_show', ['issue_id'=>$issue['id']]);
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
