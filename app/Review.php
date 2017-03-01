<?php 


namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\User;

class Review extends Model {
	protected $table = 'reviews';
	protected $fillable = ['user_id', 'prod_id', 'name', 'details', 'rating', 'aproved'];

	public function prod() {
		return $this->belongsTo('App\Prod');
	}

	public function user(){
		return $this->belongsTo('App\User');
	}

}

