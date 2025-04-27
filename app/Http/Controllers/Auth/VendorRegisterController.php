<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class VendorRegisterController extends Controller
{
    public function create()
    {
        return view('auth.register-vendor');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'business_name' => 'required',
            'business_license' => 'required',
        ]);

         User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'business_name' => $request->business_name,
            'business_license' => $request->business_license,
        ]);

        return redirect('/')->with('message', 'Vendor registration submitted. Wait for admin approval.');
    }
}
