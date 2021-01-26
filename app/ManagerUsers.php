<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagerUsers extends Model
{
    protected $fillable = [
    	'id_user_manager',
    	'id_user_hitmen',
    ];
}
