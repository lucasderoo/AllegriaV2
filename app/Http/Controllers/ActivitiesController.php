<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

use App\ActivitiesSignup;
use App\Activities;
use App\user;

class ActivitiesController extends Controller
{
    public function index()
    {
    	$user_id = Auth::user()->id;
    	$active_activities = Activities::get_active_activities();
    	$all_activities = Activities::get_all_activities();
        $signed_up_activities = Activities::get_signed_up_activities($user_id);

        return view('activities.index', compact('active_activities','all_activities','signed_up_activities'));
    }

    public function add()
    {
    	return view('activities.add');
    }

    public function addACTION()
    {
    	Activities::addAction();
    	return redirect('activities'); 
    }


    public function overview($id)
    {
    	$get_activitie = Activities::get_activitie_by_id($id);
    	$get_activitie_signup = Activities::get_activitie_signup($id);
    	return view('activities.overview', compact('get_activitie','get_activitie_signup'));
    }

    public function signup($id)
    {
    	$user_id = Auth::user()->id;
    	$get_activitie = Activities::get_activitie_by_id($id);
    	$get_member = User::get_member($user_id);
    	return view('activities.signup', compact('get_activitie','get_member','id'));
    }

    public function signupACTION($id)
    {
    	$user_id = Auth::user()->id;
    	$member_id = User::get_member_id($user_id);

    	$new_activitie_signup = ActivitiesSignup::create([
			'activity_id' => $id,
			'member_id' => $member_id,
			'place' => $_POST['place'],
			'comments' => $_POST['comments'],
		]);
    }
}

