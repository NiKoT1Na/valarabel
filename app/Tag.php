<?php 


namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
	protected $table = 'tag';
	protected $fillable = ['name'];

	public function prods() {
		return $this->belongsToMany('App\Prod');
	}

}

