<?php 


namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	protected $table = 'categories';
	protected $fillable = ['name'];
	
	public function Prods() {
		return $this->hasmany('app\Prod');
	}

}