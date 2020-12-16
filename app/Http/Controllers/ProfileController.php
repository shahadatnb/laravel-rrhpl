<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\User;
use Session;
use Auth;

class ProfileController extends Controller
{

    public function index(){
        return view('pages.profile');
    }

    public function editProfile(){
        $user_id = User::find(Auth::User()->id); 
        return view('profile.edit')->withUser($user_id);
    }

    public function updateProfile(Request $request){
        $user_id = Auth::User()->id; 
        $this->validate($request, array(
            'name' => 'required|string|max:255',
            'username' => [
                'required','alpha_dash','max:30',
                Rule::unique('users')->ignore($user_id),
            ],
            'email' => 'required|string|email|max:255',
            'mobile' => 'required',
        ));

                              
        $data = User::find(Auth::User()->id);
        
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->save();
        Session::flash('success','Successfully Save');

        return redirect()->route('profile');
    }

    public function changePass(){
        return view('profile.changePass');
    }

    public function changePhoto(Request $request){
    	$this->validate($request, array(
        'photo' => 'mimes:jpg,jpeg,png|max:2000'
        ));

        $user_id = Auth::User()->id;                       
        $data = User::find($user_id);
        $image = $request->file('photo');
        if ($image) {
            $upload = 'public/upload/member';
            $filename = time() . '_' . $image->getClientOriginalName();
            $success = $image->move($upload, $filename);

            if ($success) {
                $data->photo = $filename;
                $data->save();
                Session::flash('success','Successfully Save');

                return redirect()->route('profile');
            } else {
                Session::flash('warning', "Image couldn't be uploaded.");
                return redirect()->route('profile');
            }
        }
    }
    
    public function changePassSave(Request $request){
    	$this->validate($request, array(
            'CurrentPassword'=>'required|max:15',
            'password' => 'required|string|min:6|max:15|confirmed',
            ));
    	//return Auth::user()->password.'<BR>'.Hash::make($request->CurrentPassword);

    	if(Hash::check($request->CurrentPassword, Auth::user()->password )){
    		$user_id = Auth::User()->id;                       
	        $obj_user = User::find($user_id);
	        $obj_user->password = Hash::make($request->password);
	        $obj_user->save();
            Session::flash('success', "Your Password Successfully Changed.");
	        return redirect()->route('profile');
    	}else{
    		return redirect()->route('changePass');
    	}

    }
}
