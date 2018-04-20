<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function __construct() {
        return $this->middleware(['auth','permission:manage']);
    }

    // public function testAddLog()
    // {
    // 	\Log::addToLog('My Testing add-to-log');
    // 	dd('log inserted successfully');
    // }

    public function log()
    {
    	$logs = \Log::logLists();

    	return view('pages.logs',compact('logs'));
    }

    public function logdel()
    {
        \Log::logDelete();

        return redirect('logs');
    }
}
