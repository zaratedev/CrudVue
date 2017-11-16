<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	protected $fillable = [
    	'title',
    	'departure_id'
	];

	public function departure()
	{
		return $this->belongsTo('App\Departure');
	}
}
