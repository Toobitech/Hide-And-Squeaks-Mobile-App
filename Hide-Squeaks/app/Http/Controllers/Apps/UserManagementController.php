<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.user-management.users.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.apps.user-management.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
    public function myProfile(){
        $user = auth()->user();
        return view('pages.apps.profile.edit',compact('user'));
    }

    public function myProfileUpdateEmail(Request $request){
        $user = auth()->user();

        $request->validate([

            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            // Add more validation rules as needed
        ]);

        $user->update([
            'email' => $request->input('email'),
            // Update more user details as needed
        ]);

        return redirect()->route('myprofile')->with('success', 'Profile updated successfully');
    }
    public function myProfileUpdateName(Request $request){
        $user = auth()->user();

        $request->validate([

            'name' => 'required',
            // Add more validation rules as needed
        ]);

        $user->update([
            'name' => $request->input('name'),
            // Update more user details as needed
        ]);

        return redirect()->route('myprofile')->with('success', 'Profile updated successfully');
    }
    public function myProfileUpdatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        // Check if the entered current password matches the user's actual password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->route('myprofile')->with('error', 'Current password is incorrect');
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return redirect()->route('myprofile')->with('success', 'Password updated successfully');
    }
}
