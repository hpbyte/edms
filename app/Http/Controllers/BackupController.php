<?php

namespace App\Http\Controllers;

use Alert;
use Illuminate\Http\Requests;
use Artisan;
use Storage;

class BackupController extends Controller
{
    public function __construct()
    {
    	return $this->middleware(['auth','role:Root']);
    }

    public function index()
    {
    	$disk = Storage::disk('local');

        // $files = $disk->files('http---localhost');
        $files = $disk->files('http---127.0.0.1-8000');
        $backups = [];
        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    // 'file_name' => str_replace('http---localhost' . '/', '', $f),
                    'file_name' => str_replace('http---127.0.0.1-8000' . '/', '', $f),
                    'file_size' => $disk->size($f),
                    'last_modified' => $disk->lastModified($f),
                ];
            }
        }
        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);

    	return view('pages.backup',compact('backups'));
    }

    public function create()
    {
        try {
            // start the backup process
            Artisan::call('backup:run');
            $output = Artisan::output();
            // log the results
            \Log::addToLog('Created a backup');

            return redirect('/backup')->with('success','Backup Created');
        } catch (Exception $e) {
            return redirect('/backup')->with('error','Backup Failed');
        }
    }

    public function download()
    {
        $disk = Storage::disk('local');
        // $file_name = 'http---localhost/' . request()->input('file_name');
        $file_name = 'http---127.0.0.1-8000/' . request()->input('file_name');
        $adapter = $disk->getDriver()->getAdapter();

        $storage_path = $disk->getDriver()->getAdapter()->getPathPrefix();

        if ($disk->exists($file_name))
        {
            \Log::addToLog('Backup File Downloaded');
            return response()->download($storage_path.$file_name);
        } else {
            return redirect('/backup')->with('error','404 File Not Found');
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete()
    {
        $disk = Storage::disk('local');
        // $file_name = 'http---localhost/' . request()->input('file_name');
        $file_name = 'http---127.0.0.1-8000/' . request()->input('file_name');

        if ($disk->exists($file_name))
        {
            $disk->delete($file_name);
            \Log::addToLog('Backup File Deleted');

            return redirect('/backup')->with('success','Backup File Deleted');
        } else {
            return redirect('/backup')->with('error','404 File Not Found');
        }
    }
}
