<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\User;

class VendorRegisterController extends Controller
{
    public function create()
    {
        $brands = Brand::all();
        return view('auth.register-vendor',compact('brands'));
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
            'brands' => 'required|array',
            'brands.*' => 'exists:brands,id',
        ]);

        $user=  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'business_name' => $request->business_name,
            'business_license' => $request->business_license,
        ]);

         $user->brands()->attach($request->brands);

        return redirect('/')->with('message', 'Vendor registration submitted. Wait for admin approval.');
    }
}
