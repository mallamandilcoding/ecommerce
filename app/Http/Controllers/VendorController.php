<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function VendorDashboard(){
        return view('vendor.index');
    }

    public function VendorLogin(){
        return view('vendor.login');
    }
    public function VendorDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    }

    public function VendorProfile(){
        $id= Auth::user()->id;
        $vendorData = User::find($id);
        return view('vendor.vendor_profile_view',compact('vendorData'));
    }

    public function VendorProfileStore(Request $req){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $req->name;
        $data->email = $req->email;
        $data->phone = $req->phone;
        $data->address = $req->address;
        $data->vendor_join = $req->vendor_join;
        $data->vendor_short_info = $req->vendorinfo;
        if ($req->file('photo')){
            $file = $req->file('photo');
            $filename = date('YmdHi').$file->getClientOriginalName();
            //upload image to public folder
            $file->move(public_path('upload/vendor_images'),$filename);
            //save to db
            $data['photo'] = $filename;
        }
        $data->save();
        //toster message
        $notification = array(
            'message' => 'vendor data updated succesesfullly',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function VendorChangePassword(){
        return view('vendor.vendor_change_password');
    }

    public function VendorUpdatePassword(Request $req){
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
