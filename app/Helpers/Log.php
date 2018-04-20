<?php

namespace App\Helpers;
use Request;
use App\Log as LogModel;

/**
* 
*/
class Log
{
	public static function addToLog($subject)
	{
		$log = [];
		$log['subject'] = $subject;
		$log['url'] = Request::fullUrl();
		$log['method'] = Request::method();
		$log['ip'] = Request::ip();
		$log['agent'] = Request::header('user-agent');
		$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
		LogModel::create($log);
	}

	public static function logLists()
	{
		return LogModel::latest()->get();
	}

	public static function logDelete()
	{
		LogModel::truncate();
	}
}