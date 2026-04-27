<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    // direct change password page
    public function changePasswordPage() {
        return view('admin.profile.changePasswordPage');
    }

    // change password
    public function changePassword(Request $request) {
        $this->checkPasswordValidation($request);

        if( Hash::check($request->oldPassword, Auth::user()->password) ) {
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            Alert::success('Success Title', 'Password Changed Successfully!');
            return back();

        }else {
            return back()->with('errorMessage', 'Old Password is not correct. Try Again!');
        }
    }

    // edit profile
    public function edit() {
        return view('admin.profile.edit');
    }

    // update profile
    public function update(Request $request) {
        $this->checkProfileValidation($request);

        $data = $this->getProfileData($request);

        if( $request->hasFile('image') ) {

            if( Auth::user()->profile != null ) {
                if( file_exists(public_path('profile/'. Auth::user()->profile)) ) {
                    unlink(public_path('profile/'. Auth::user()->profile));
                }
            }

            $imgName =  uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move( public_path() . '/profile/' , $imgName );
            $data['profile'] = $imgName;

        }else {
            $data['profile'] = Auth::user()->profile;
        }

        User::where('id', Auth::user()->id)->update($data);

        Alert::success('Success Title', 'Profile Updated Successfully!');

        return back();
    }

    // check password validation
    private function checkPasswordValidation($request) {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword',
        ]);
    }

    // check profile validation
    private function checkProfileValidation($request) {
        $request->validate([
            'image' => 'file|mimes:jpg,jpeg,png,webp,svg,gif',
            'name' => 'required',
            'email' => 'required|unique:users,email,'. Auth::user()->id,
            'phone' => 'max:12',
            'address' => 'max:100',
        ]);
    }

    // get profile data
    private function getProfileData($request) {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }
}
