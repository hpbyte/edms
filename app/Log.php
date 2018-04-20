<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
    	'subject', 'url', 'method', 'ip', 'agent', 'user_id'
    ];
}
