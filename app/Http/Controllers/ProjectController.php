<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // need_fix: need to do for showing all the project and allow to add them to user
        $user = Auth::user();
        $projects = $user->projects()->get()->toArray();
        // return view('project.index', compact('projects'));
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
        return view('home');
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
        $project->save();
        //返回页面
        return redirect()->route('project.create')->with('success', 'Data Added');
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
        return view('project.show', ['project' => Project::findOrFail($id)]);
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
        $project = Project::find($id);
        return view('project.edit', compact('project', 'id'));
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
            'project_name'    =>  'required'
        ]);
        $project = Project::find($id);
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
    public function destroy($id)
    {
        //
        $project = Project::find($id);
        $project->delete();
        return redirect()->route('/home')->with('success', 'Data Deleted');
    }
}
