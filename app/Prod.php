<?php 


namespace App;

use Illuminate\Database\Eloquent\Model;

class Prod extends Model {
	protected $table = 'prod';
	protected $fillable = ['user_id', 'name', 'file', 'details', 'price', 'inv'];

	public function tags() {

		return $this->belongsToMany('App\Tag', 'prod_tags', 'prod_id', 'tag_id');
	}

}

