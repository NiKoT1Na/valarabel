<?php 


namespace App;

use Illuminate\Database\Eloquent\Model;

class Prod extends Model {
	protected $table = 'prod';
	protected $fillable = ['user_id', 'name', 'file', 'category_id','details', 'price', 'inv'];

	public function tags() {

		return $this->belongsToMany('App\Tag');
	}

	public function images() {

		return $this->hasMany('App\Image');
	}

	public function category() {

		return $this->belongsTo('App\Category');
	}

	public function reviews() {

		return $this->hasMany('App\Review');
	}


	// public function withTag() {

	// 	return $this->belongsToMany('App\Tag')->whereIn('prod_tag.tag_id', [9]);
	// }


}

