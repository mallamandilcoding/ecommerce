<?php

namespace App\Http\Controllers;
<<<<<<< HEAD


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
=======
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;
>>>>>>> d0f345eae20683c34c072b9e27516852df76eb56

class UserController extends Controller
{
    public function UserDashboard(){
        $id = Auth::user()->id;
        $userData = User::find($id);
<<<<<<< HEAD
        return view('user_dashboard',compact('userData'));
    }

    public function UserDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
=======
        return view('dashboard',compact('userData'));
>>>>>>> d0f345eae20683c34c072b9e27516852df76eb56
    }
}
