<?php 


namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
	protected $table = 'reviews';
	protected $fillable = ['user_id', 'prod_id', 'name', 'details', 'rating'];

	public function prods() {
		return $this->belongsTo('App\Prod');
	}

}

