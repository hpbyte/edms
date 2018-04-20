<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\Category;
use Illuminate\Support\Facades\Storage;
use DB;

class DocumentsController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('Root'))
        {
            // get all
            $docs = Document::where('isExpire','!=',2)->get();
        }
        else
        {
            // get user's docs
            // $user_id = auth()->user()->id;

            // $docs = Document::where('user_id',$user_id)->get();

            // get docs in dept
            $dept_id = auth()->user()->department_id;

            $docs = Document::where('isExpire','!=',2)->where('department_id',$dept_id)->where('user_id','!=',auth()->user()->id)->get();
        }
        $filetype = null;

        return view('documents.index',compact('docs','filetype'));
    }

    // my documents
    public function mydocuments()
    {
        // get user's docs
        $user_id = auth()->user()->id;

        $docs = Document::where('user_id',$user_id)->get();

        return view('documents.mydocuments',compact('docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name','id')->all();

        return view('documents.create',compact('categories'));
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
          'name' => 'required|string|max:255',
          'description' => 'required|string|max:255',
          'file' => 'required|max:50000',
        ]);

        // get the data of uploaded user
        $user_id = auth()->user()->id;
        $department_id = auth()->user()->department_id;

        // handle file upload
        if ($request->hasFile('file')) {
            // filename with extension
            $fileNameWithExt = $request->file('file')->getClientOriginalName();
            // filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // extension
            $extension = $request->file('file')->getClientOriginalExtension();
            // filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // upload file
            $path = $request->file('file')->storeAs('public/files/'.$user_id, $fileNameToStore);
        }

        $doc = new Document;
        $doc->name = $request->input('name');
        $doc->description = $request->input('description');
        $doc->user_id = $user_id;
        $doc->department_id = $department_id;
        $doc->file = $path;
        $doc->mimetype = Storage::mimeType($path);
        $size = Storage::size($path);
        if ($size >= 1000000) {
          $doc->filesize = round($size/1000000) . 'MB';
        }elseif ($size >= 1000) {
          $doc->filesize = round($size/1000) . 'KB';
        }else {
          $doc->filesize = $size;
        }
        // determine whether it expires
        if ($request->input('isExpire') == true) {
            $doc->isExpire = false;
        }else {
            $doc->isExpire = true;
            $doc->expires_at = $request->input('expires_at');
        }
        // save to db
        $doc->save();
        // add Category
        $doc->categories()->sync($request->category_id);

        \Log::addToLog('New Document, '.$request->input('name').' was uploaded');

        return redirect('/documents')->with('success','File Uploaded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doc = Document::findOrFail($id);

        return view('documents.show',compact('doc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doc = Document::findOrFail($id);
        $categories = Category::pluck('name','id')->all();

        return view('documents.edit',compact('doc','categories'));
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
          'name' => 'required|string|max:255',
          'description' => 'required|string|max:255'
        ]);

        $doc = Document::findOrFail($id);
        $doc->name = $request->input('name');
        $doc->description = $request->input('description');
        // determine whether it expires
        if ($request->input('isExpire') == true) {
            $doc->isExpire = false;
            $doc->expires_at = null;
        }else {
            $doc->isExpire = true;
            $doc->expires_at = $request->input('expires_at');
        }
        $doc->save();

        \Log::addToLog('Document ID '.$id.' was edited');

        return redirect('/documents')->with('success','Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doc = Document::findOrFail($id);
        // delete the file on disk
        Storage::delete($doc->file);
        // delete db record
        $doc->delete();
        // delete associated categories
        $doc->categories()->detach();

        \Log::addToLog('Document ID '.$id.' was deleted');

        return redirect('/documents')->with('success','Deleted!');
    }

    // delete multiple docs selected
    public function deleteMulti(Request $request)
    {
      $ids = $request->ids;
      DB::table('document')->whereIn('id',explode(',', $ids))->delete();

      \Log::addToLog('Selected Documents Are Deleted!');

      return redirect('/documents')->with('success','Selected Documents Deleted!');
    }

    // opening file
    public function open($id)
    {
        $doc = Document::findOrFail($id);
        $path = Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix($doc->file);
        $type = $doc->mimetype;

        \Log::addToLog('Document ID '.$id.' was viewed');

        if ($type == 'application/pdf' || $type == 'image/jpeg' ||
        $type == 'image/png' || $type == 'image/jpg' || $type == 'image/gif')
        {
            return response()->file($path, ['Content-Type' => $type]);
        }
        elseif ($type == 'video/mp4' || $type == 'audio/mpeg' ||
        $type == 'audio/mp3' || $type == 'audio/x-m4a')
        {
            return view('documents.play',compact('doc'));
        }
        else {
            return response()->file($path, ['Content-Type' => $type]);
        }
    }

    // download file
    public function download($id)
    {
        $doc = Document::findOrFail($id);
        $path = Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix($doc->file);
        $type = $doc->mimetype;

        \Log::addToLog('Document ID '.$id.' was downloaded');

        // return response()->download($path, $doc->name, ['Content-Type:' . $type]);
        return response()->download($path);
    }

    // searching
    public function search(Request $request)
    {
        $this->validate($request,[
          'search' => 'required|string'
        ]);

        $srch = strtolower($request->input('search'));
        $names = Document::pluck('name')->all();
        $results = [];

        for ($i=0; $i < count($names); $i++) {
          $lower = strtolower($names[$i]);
          if (strpos($lower, $srch) !== false) {
            $results[$i] = Document::where('name', $names[$i])->get();
          }
        }

        return view('documents.results', compact('results'));
    }

    // sorting
    public function sort(Request $request)
    {
        $filetype = $request->input('filetype');

        $docs = Document::where('mimetype',$filetype)->get();

        return view('documents.index', compact('docs', 'filetype'));
    }

    public function trash()
    {
      // make expired documents
      $docs = Document::where('isExpire',1)->get();
      $today = Date('Y-m-d');

      foreach ($docs as $d) {
        if ($today > $d->expires_at) {
          $maketrash = Document::findOrFail($d->id);
          $maketrash->isExpire = 2;
          $maketrash->save();
        }
      }
      // find out auth user role
      $user = auth()->user();
      // find trashed documents
      if ($user->hasRole('Root')) {
        $trash = Document::where('isExpire',2)->get();
      } elseif ($user->hasRole('Admin')) {
        $trash = Document::where('isExpire',2)->where('department_id',$user->department_id)->get();
      } else {
        $trash = Document::where('isExpire',2)->where('user_id',$user->id)->get();
      }

      return view('documents.trash', compact('trash'));
    }

    public function restore($id)
    {
      $restoreDoc = Document::findOrFail($id);
      $restoreDoc->isExpire = 0;
      $restoreDoc->expires_at = null;
      $restoreDoc->save();

      return redirect()->back()->with('success','Successfully Restored!');
    }

}
