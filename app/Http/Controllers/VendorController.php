<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        $adminData = User::find($id);
        return view('vendor.vendor_profile_view',compact('adminData'));
    }
}
