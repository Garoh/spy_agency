<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hit extends Model
{
    protected $fillable = [
    	'id_user_assigned',
    	'description',
    	'target',
    	'status',
    	'id_user_creator'
    ];

    public function assigned()
    {
    	return $this->belongsTo(User::class, 'id_user_assigned');
    }

    public function creator()
    {
    	return $this->belongsTo(User::class, 'id_user_creator');
    }

    public function getStatus()
    {
    	$status = ['Assigned', 'Failed', 'Completed'];

    	return $status[$this->status];
    }
}
