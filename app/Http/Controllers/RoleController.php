<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class RoleController extends Controller
{
    public function getAdminPage(){
    	$users = User::All();
    	return view('Admin')->withUsers($users);
    }

    public function postAssignRole(Request $request){
    	//dd($request);

    	$user = User::where('email',$request['email'])->first();
    	$user->roles()->detach();
    	
    	if($request['role_store']){
    		$user->roles()->attach(Role::where('name','Store')->first());
    	}
    	
    	if($request['role_lab']){
    		$user->roles()->attach(Role::where('name','Lab')->first());
    	}

        if($request['role_hr']){
            $user->roles()->attach(Role::where('name','HR')->first());
        }

    	if($request['role_admin']){
    		$user->roles()->attach(Role::where('name','Admin')->first());
    	}
    	return redirect()->back();
    }

}
