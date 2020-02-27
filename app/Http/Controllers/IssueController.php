<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\History;
use App\Http\Controllers\Controller;
use App\Issue;
use App\Mail\UpdateHistory;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class IssueController extends Controller
{
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

        $this->middleware('permission:create_issues', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_issues', ['only' => ['edit', 'update']]);
        //  $this->middleware('permission:change_status', ['only' => ['change_status']]);
        $this->middleware('permission:attach_file', ['only' => ['attachFile']]);
    }

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
        return view('issue.index', compact('issues', 'project_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id)
    {
        //
        return view('issue.create', compact('project_id'));
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
            'type' => 'required',
            'subject' => 'required',
            'description' => 'required',
            'priority' => 'required',
            'severity' => 'required',
            'category' => 'required',
            'version' => 'required',
        ]);
        //创造新variable 并copy 输入的数据
        $user = Auth::user();
        $issue = new Issue([
            'project_id' => $request->get('project_id'),
            'post_user_id' => $user['id'],
            'type' => $request->get('type'),
            'subject' => $request->get('subject'),
            'description' => $request->get('description'),
            'priority' => $request->get('priority'),
            'severity' => $request->get('severity'),
            'category' => $request->get('category'),
            'version' => $request->get('version'),
            'status' => 'Open',
        ]);
        //储存数据
        $issue->save();
        $project = Project::findOrFail($request->get('project_id'));
        $issues = $project->issues()->get();

        //create history
        $user_name = $user['name'];
        $project_name = $project['project_name'];
        $issue_id = $issue['id'];

        $action_log = "$user_name <span class=\"badge badge-success\">Create</span> a new issue $issue_id for $project_name";

        $history = new History([
            'user_id' => $user['id'],
            'project_id' => $project['id'],
            'issue_id' => $issue['id'],
            'action_log' => $action_log,
        ]);

        $history->save();

        //返回页面
        return view('issue.index', ['project_id' => $request->get('project_id')])->with('issues', $issues);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($project_id, $issue_id)
    {
        //
        $user = Auth::user();
        $issue = Issue::find($issue_id);
        $project_id = Project::find($project_id);
        // $this->checkRole($project_id);
        $comments = $issue->comments()->get();
        $attached_file = $issue->attachments()->get();
        return view('issue.show', compact('project_id', 'comments', 'issue', 'attached_file'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id, $issue_id)
    {
        //

        $issue = Issue::find($issue_id);
        $project = Project::find($project_id);
        $issue_project = $project->get()->first();
        // $this->checkRole($project_id);
        $comments = $issue->comments()->get();
        $project_members = $project->users()->get()->toArray();

        return view('issue.edit', ['project_id' => $project_id, 'issue_id' => $issue_id], compact('issue', 'issue_id', 'project', 'project_id', 'project_members', 'comments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id, $issue_id)
    {

        $user = Auth::user();

        //validate input data
        $this->validate($request, [
            'type' => 'required',
            'subject' => 'required',
            'description' => 'required',
            'priority' => 'required',
            'severity' => 'required',
            'category' => 'required',
            'version' => 'required',
            'status' => 'required',
        ]);

        $issue = Issue::find($issue_id);

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

        $action_log = "$user_name had been <span class=\"badge badge-success\">Edit</span> issue $issue_id in $project_name";

        $history = new History([
            'user_id' => $user['id'],
            'project_id' => $project['id'],
            'issue_id' => $issue['id'],
            'action_log' => $action_log,
        ]);

        $history->save();

        return redirect()->route('issue_show', ['project_id' => $project['id'], 'issue_id' => $issue['id']]);
    }

    //problem : not in used
    public function updateStatus(Request $request)
    {
        $this->validate($request, [
            'status'    =>  'required',
        ]);

        $issue = Issue::find($request->get('issue_id'));

        $issue->status = $request->get('status');

        $issue->save();
    }

    public function attachFile(Request $request, $project_id,  $issue_id)
    {
        $this->validate($request, [
            'attchFile' => 'required|file|max:5000',
        ]);

        $user = Auth::user();
        $issue = Issue::find($issue_id);

        $uploadedFile = $request->file('attchFile');
        $fileName = $uploadedFile->getClientOriginalName();
        $path = $uploadedFile->store('uploaded_file');
        $attachment = new Attachment([
            'uploaded_user_id' => $user['id'],
            'attached_issue_id' => $issue['id'],
            'path' => $path,
            'file_name' => $fileName,
        ]);

        $attachment->save();

        return redirect()->route('issue_show', ['project_id' => $project_id, 'issue_id' => $issue_id]);
    }

    public function download($id)
    {
        $file = Attachment::find($id);
        $path = $file->path;
        $pathToFile = storage_path('app\\') . str_replace('/', '\\', $path);
        $file_name = $file->file_name;
        return response()->download($pathToFile, $file_name);
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
