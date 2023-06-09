<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function UserDashboard(){
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('user_dashboard',compact('userData'));
    }

    public function UserDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');

    }

    public function UserProfileStore(Request $req){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $req->username;
        $data->name = $req->name;
        $data->email = $req->email;
        $data->phone = $req->phone;
        $data->address = $req->address;

        if ($req->file('photo')){
            $file = $req->file('photo');
            $filename = date('YmdHi').$file->getClientOriginalName();
            //upload image to public folder
            $file->move(public_path('upload/user_images'),$filename);
            //save to db
            $data['photo'] = $filename;
        }
        $data->save();
        //toster message
        $notification = array(
            'message' => 'user data updated succesesfullly',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function UserUpdatePassword(Request $req){
        $req->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        //match the old passowrd
        if (!Hash::check($req->old_password,Auth::user()->password)) {
            return back()->with('error', "old password does not match");
        }
        //update new password
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($req->new_password)
        ]);
        return back()->with('status','password changed succesfully');

    }
}
