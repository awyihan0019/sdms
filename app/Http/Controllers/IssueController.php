<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Issue;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('issue.create');
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
        $issue = new Issue([
            'type'    =>  $request->get('type'),
            'subject'    =>  $request->get('subject'),
            'description'    =>  $request->get('description'),
            'priority'    =>  $request->get('priority'),
            'severity'    =>  $request->get('severity'),
            'category'    =>  $request->get('category'),
            'version'    =>  $request->get('version'),
            'due_date'    =>  $request->get('due_date')
        ]);
        //储存数据
        $issue->save();
        //返回页面
        return redirect()->route('issue.create')->with('success', 'Data Added');
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
