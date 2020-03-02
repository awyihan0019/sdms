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
        $this->middleware('permission:change_status', ['only' => ['updateStatus']]);
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
        $issues = $project->issues()->whereIn('status', ['Open', 'In Progress'])->orderByRaw("FIELD(priority, \"high\", \"normal\", \"low\")")->get();
        return view('issue.index', ['project_name' => $project['project_name']], compact('issues', 'project_id'));
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
        return view('issue.create', ['project_name' => $project['project_name']], compact('project_id'));
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
        $issues = $project->issues()->whereIn('status', ['Open', 'In Progress'])->orderByRaw("FIELD(priority, \"high\", \"normal\", \"low\")")->get();

        //create history
        $user_name = $user['name'];
        $project_name = $project['project_name'];
        $issue_id = $issue['id'];

        $action_log = "<strong>$user_name</strong> <span class=\"badge badge-success\">Create</span> a new <strong>issue#$issue_id</strong> for <strong>$project_name</strong>";

        $history = new History([
            'user_id' => $user['id'],
            'project_id' => $project['id'],
            'issue_id' => $issue['id'],
            'action_log' => $action_log,
        ]);

        $history->save();

        //返回页面
        return view('issue.index', ['project_id' => $request->get('project_id'), 'project_name' => $project_name])->with('issues', $issues);
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
        $project = Project::find($project_id);
        // $this->checkRole($project_id);
        $comments = $issue->comments()->get()->sortByDesc('created_at');
        $attached_file = $issue->attachments()->get();
        return view('issue.show', ['project_name' => $project['project_name']], compact('project_id', 'comments', 'issue', 'attached_file'));

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

        return view('issue.edit', ['project_id' => $project_id, 'project_name' => $project['project_name'], 'issue_id' => $issue_id], compact('issue', 'issue_id', 'project', 'project_id', 'project_members', 'comments'));
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

        //problem : get original and compare with getChanges
        // dd($issue->getOriginal(), $issue->getChanges());
        //email notification
        if ($request->get('mail_notification') == "true") {
            Mail::to($request->user())->send(new UpdateHistory());
        }

        //create history
        $user_name = $user['name'];
        $project = $issue->project()->get()->first();
        $project_name = $project['project_name'];

        $action_log = "<strong>$user_name</strong> had been <span class=\"badge badge-success\">Edit</span> <strong>issue#$issue_id</strong> in <strong>$project_name</strong>";

        $history = new History([
            'user_id' => $user['id'],
            'project_id' => $project['id'],
            'issue_id' => $issue['id'],
            'action_log' => $action_log,
        ]);

        $history->save();

        return redirect()->route('issue_show', ['project_id' => $project['id'], 'issue_id' => $issue['id'], 'project_name' => $project_name]);
    }

    public function updateStatus(Request $request, $project_id, $issue_id)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);

        $issue = Issue::find($issue_id);
        $project = Issue::find($project_id);

        $issue->status = $request->get('status');

        $issue->save();

        return redirect()->route('issue_show', ['project_id' => $project_id, 'issue_id' => $issue_id, 'project_name' => $project['project_name']]);
    }

    public function attachFile(Request $request, $project_id, $issue_id)
    {
        $this->validate($request, [
            'attchFile' => 'required|file|max:5000',
        ]);

        $user = Auth::user();
        $issue = Issue::find($issue_id);
        $project = Project::find($project_id);

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

        return redirect()->route('issue_show', ['project_id' => $project_id, 'issue_id' => $issue_id, 'project_name' => $project['project_name']]);
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

    public function priorityControl($project_id)
    {
        //
        $project = Project::find($project_id);
        $issues = $project->issues()->whereIn('status', ['Open', 'In Progress'])->get();
        $suggested_issues = $issues->map(function ($row) {
            $this->suggestionDefine($row);
            if ($row['suggested_priority'] == $row['priority']) {
                return null;
            }
            return $row;
        });
        return view('issue.priority_prediction', ['project_name' => $project['project_name']], compact('suggested_issues', 'project_id'));
    }

    public function suggestionDefine($issue)
    {
        $priority_level = 0;
        $suggested_priority;
        $reason = "";

        //check due date
        if (empty($issue['due_date'])) {
            $priority_level += 2;
            $reason .= "Due date : No set due date <i class=\"fas fa-equals\" style =\"color:blue\"></i><br>";
        } else {
            if (strtotime($issue['due_date']) - strtotime(date('Ymd')) < 259200) {
                $priority_level += 5;
                $reason .= "Due date : less than 3 days <i class=\"fas fa-arrow-up\" style =\"color:red\"></i><br>";
            } else if (strtotime($issue['due_date']) - strtotime(date('Ymd')) < 604800) {
                $priority_level += 2;
                $reason .= "Due date : less than 7 days <i class=\"fas fa-equals\" style =\"color:blue\"></i><br>";
            } else {
                $priority_level += 1;
                $reason .= "Due date : more than 7 days   <i class=\"fas fa-arrow-down\" style =\"color:green\"></i><br>";
            }
        }

        //check created date
        if (strtotime("now") - strtotime($issue['created_at']) > 1209600) {
            $priority_level += 5;
            $reason .= "Issue Created date : more than 14 days <i class=\"fas fa-arrow-up\" style =\"color:red\"></i><br>";
        } else if (strtotime("now") - strtotime($issue['created_at']) > 604800) {
            $priority_level += 2;
            $reason .= "Issue Created date : more than 7 days <i class=\"fas fa-equals\" style =\"color:blue\"></i><br>";
        } else {
            $priority_level += 1;
            $reason .= "Issue Created date : less than 7 days   <i class=\"fas fa-arrow-down\" style =\"color:green\"></i><br>";
        }

        //check catogory
        if ($issue['category'] == 'Database') {
            $priority_level += 5;
            $reason .= "Issue Category : related to database <i class=\"fas fa-arrow-up\" style =\"color:red\"></i><br>";
        } else if ($issue['category'] == 'Functionality') {
            $priority_level += 2;
            $reason .= "Issue Category : related to functionality <i class=\"fas fa-equals\" style =\"color:blue\"></i><br>";
        } else {
            $priority_level += 1;
            $reason .= "Issue Category : related to user interface   <i class=\"fas fa-arrow-down\" style =\"color:green\"></i><br>";
        }

        //check severity
        if ($issue['severity'] == 'high') {
            $priority_level += 5;
            $reason .= "Issue severity : severity is high <i class=\"fas fa-arrow-up\" style =\"color:red\"></i><br>";
        } else if ($issue['severity'] == 'normal') {
            $priority_level += 2;
            $reason .= "Issue severity : severity is normal <i class=\"fas fa-equals\" style =\"color:blue\"></i><br>";
        } else {
            $priority_level += 1;
            $reason .= "Issue severity : severity is low   <i class=\"fas fa-arrow-down\" style =\"color:green\"></i><br>";
        }

        //check the priority level
        if ($priority_level >= 12) {
            $suggested_priority = 'high';
        } else if ($priority_level >= 8) {
            $suggested_priority = 'normal';
        } else {
            $suggested_priority = 'low';
        }

        //define the suggested reason and suggested priority
        $issue->priority_level = $priority_level;
        $issue->suggested_priority = $suggested_priority;
        $issue->reason = $reason;
        return $issue;
    }

    public function updatePriority(Request $request, $project_id, $issue_id)
    {
        $this->validate($request, [
            'suggested_priority' => 'required',
        ]);

        $issue = Issue::find($issue_id);

        $issue->priority = $request->get('suggested_priority');

        $issue->save();

        return redirect()->route('priority_control', ['project_id' => $project_id]);
    }
}
