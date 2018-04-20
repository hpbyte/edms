<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

class DepartmentsController extends Controller
{
    public function __construct() {
        return $this->middleware(['auth','role:Root']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();

        return view('departments.index')->with('departments',$departments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'dptName' => 'required',
        ]);

        $dept = Department::create($request->only('dptName'));

        \Log::addToLog('New department '.$request->input('dptName').' was added');

        return redirect('/departments')->with('success','Department Added');
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
        $dept = Department::findOrFail($id);

        return view('departments.edit',compact('dept'));
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
        $this->validate($request, [
          'dptName' => 'required',
        ]);

        $dept = Department::findOrFail($id);
        $dept->dptName = $request->input('dptName');
        $dept->save();

        \Log::addToLog('Department ID '.$id.' was edited');

        return redirect('/departments')->with('success','Department Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dept = Department::find($id);
        $dept->delete();

        \Log::addToLog('Department ID '.$id.' was deleted');

        return redirect('/departments')->with('success','Department Deleted');
    }
}
