<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
// use Illuminate\Auth\Middleware\Authenticate;

use App\Prod;
use App\Category;
use App\Tag;
use App\Review;
use App\Dashboard;
use App\User;


class DashController extends Controller
{
  	function administrate () {
  		if (isAdmin()) {

  			$all_reviews = Review::where('aproved', 0)->with('prod', 'user')->get();  			
			$posts = "moco";
  			return view('prod.dashboard', ['posts' => $posts, 'reviews' => $all_reviews]);
  		} else
  		return redirect()->route('products.index');

 	}
}
