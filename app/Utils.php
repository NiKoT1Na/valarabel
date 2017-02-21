<?php 

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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