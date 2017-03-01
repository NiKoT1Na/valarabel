<?php 

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;

use App\Prod;
use App\Category;
use App\Tag;
use App\Review;

// PhpConsole\Helper::register();

function isAdmin()
{
	if (Auth::user()) {
		$user_role = Auth::user()->roles;
	} else {
		$user_role = false;
	}

	if ($user_role === 'admin') {
		return true;
	} else {
		return false;
	}
}
function star($rating) {
	$num = floor($rating * 2);
	$file_name = $num . 'est.png';
	return "/body/$file_name";
}

function prodStar($id) {
	$one = false;
	if (!is_array($id)) {
		$one = true;
		$id = [$id];
	}

	$prod_with_reviews = Prod::with('reviews')->findMany($id);
	$rating = $prod_with_reviews->map(function($item, $key) {
		$rating = $item->reviews->avg('rating');
		return star($rating);
	});

		// $rating = $prod_with_reviews->reviews->avg('rating');
		// $reviews = $prod_with_reviews->reviews;
		
	// return star($rating);
	if ($one) {
		return $rating[0];
	}
	return $rating;
}

function mb_ucfirst($str) {
    $fc = mb_strtoupper(mb_substr($str, 0, 1));
    return $fc.mb_substr($str, 1);
}