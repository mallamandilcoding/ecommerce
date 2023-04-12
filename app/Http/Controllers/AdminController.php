<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AdminController extends Controller
{
    public function AdminDashboard(){
        return view('admin.index');
    }

    public function AdminDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function AdminLogin(){
        return view('admin.login');
    }

    public function AdminProfile(){
        $id= Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));
    }

    public function AdminProfileStore(Request $req){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $req->name;
        $data->email = $req->email;
        $data->phone = $req->phone;
        $data->address = $req->address;
        if ($req->file('photo')){
            $file = $req->file('photo');
            $filename = date('YmdHi').$file->getClientOriginalName();
            //upload image to public folder
            $file->move(public_path('upload/admin_images'),$filename);
            //save to db
            $data['photo'] = $filename;
        }
        $data->save();
        return redirect()->back();
    }
}
