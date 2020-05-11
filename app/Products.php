<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
	protected $table = 'products';
	protected $fillable = [
		'id',
		'name',
		'description',
		'categorie_id',
		'created_at',
		'updated_at'
	];

	public function categorie()
	{
		return $this->belongsTo('App\Categories');
	}
}
