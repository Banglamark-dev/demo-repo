<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VendorApprovalController extends Controller
{
    public function index()
    {
        $vendors = User::where('role', 'vendor')->where('status', 'pending')->orWhere('status', 'requested')->get();
        //dd($vendors);
        return view('admin.vendors.index', compact('vendors'));
    }

    // public function approveVendor($id)
    // {
    //     $vendor = User::where('id', $id)->where('role', 'vendor')->firstOrFail();
    //     //dd($vendor);
    //     $vendor->update(['status' => 'approved']);

    //     // Send notification
    //     $vendor->notify(new \App\Notifications\VendorApprovedNotification());

    //     return redirect()->back()->with('message', 'Vendor approved successfully.');
    // }

    public function approveVendor(Request $request, $id)
    {
        $vendor = User::where('id', $id)->where('role', 'vendor')->firstOrFail();

        //dd($vendor->email,$vendor->password);


        $request->validate([
            'status' => 'required|in:requested,approved,pending',
        ]);

        $vendor->update([
            'status' => $request->status,
        ]);

        // Only send notification if status is 'approved'
        if ($request->status === 'approved') {
            $vendor->notify(new \App\Notifications\VendorApprovedNotification($vendor->email,$vendor->password));
        }

        return response()->json([
            'message' => 'Vendor status updated successfully.',
        ]);
    }
}
