<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = ['name'];

    public function documents() {
        return $this->belongsToMany('App\Document');
    }
}
