<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DB;

class CategoriesController extends Controller
{
    public function __construct() {
        return $this->middleware(['auth','permission:manage']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
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
            'name' => 'required'
        ]);

        $cate = Category::create($request->only('name'));

        \Log::addToLog('New category '.$request->input('name').' was added');

        return redirect('/categories')->with('success','Category Added');
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
        $category = Category::findOrFail($id);

        return view('categories.edit',compact('category'));
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
            'name' => 'string|required'
            ]);

        $category = Category::findOrFail($id);
        $category->name = $request->input('name');
        $category->save();

        \Log::addToLog('Category ID '.$id.' was edited');

        return redirect('categories')->with('success','Category Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = Category::find($id);
        $cate->delete();

        $cate->documents()->detach();

        \Log::addToLog('Category ID '.$id.' was deleted');

        return redirect('/categories')->with('success','Category Deleted');
    }

    // multiple checkbox delete
    public function deleteMulti(Request $request)
    {
        $ids = $request->ids;
        DB::table("category")->whereIn('id', explode(",", $ids))->delete();

        \Log::addToLog('All categories were deleted');

        return redirect('categories')->with('success','Categories Deleted!');
    }
}
