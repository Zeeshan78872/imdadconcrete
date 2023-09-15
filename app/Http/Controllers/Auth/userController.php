<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\View\Components\softDeleteModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class userController extends Controller
{
    // logout other user
    public function logoutUser(Request $request)
    {
        $userIdToLogout = $request->input('user_id'); // Assuming you pass user_id from the UI
        // dd($userIdToLogout);
        $userToLogout = User::find($userIdToLogout);
        $decrypted = Crypt::decryptString($userToLogout->password);
        dd($decrypted);
        if ($userToLogout) {
            Auth::logoutOtherDevices($userToLogout->password); // Assuming $userToLogout->password is the hashed password
        }
        return redirect()->route('user.index')->with('success', 'User logged out successfully');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // dd($user);
        $users = User::where('delete', 0)->get();
        return view('user.viewUser', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = getUserRole();
        return view('user.addUser', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'user_id' => ['required'],
                'name' => ['required', 'max:255'],
                'username' => ['required', 'max:255', Rule::unique('users', 'username')->ignore(1, 'delete')],
                'role' => ['required'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ],
            [
                'user_id.required' => 'User id is required.',
                'name.required' => 'Name is required.',
                'username.required' => 'Username is required.',
                'username.unique' => 'Username already exist.',
                'role.required' => 'Role is required.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password not less then 6 character.',
                'password.confirmed' => 'Password and Confirm Password do\'nt match.',
            ]
        );
        User::create([
            'user_id'  => $request->user_id,
            'name'     => $request->name,
            'username' => $request->username,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);
        Hash::decrypt($request->password);
        return redirect()->route('user.create')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $role = getUserRole();
        $user = User::find($id);
        return view('user.edit', compact('user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'user_id' => ['required'],
                'name' => ['required', 'max:255'],
                'username' => [
                    'required', 'max:255',
                    Rule::unique('users', 'username')
                        ->ignore($id)
                        ->ignore(1, 'delete')
                ],
                'role' => ['required'],
                // 'password' => ['min:6', 'confirmed'],
            ],
            [
                'user_id.required' => 'User id is required.',
                'name.required' => 'Name is required.',
                'username.required' => 'Username is required.',
                'username.unique' => 'Username already exist.',
                'role.required' => 'Role is required.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password not less then 6 character.',
                'password.confirmed' => 'Password and Confirm Password do\'nt match.',
            ]
        );
        dd($request);
    }
    public function softDelete($id)
    {
        $user = User::find($id);
        $user->delete = 1;
        $user->update();
        return redirect()->route('user.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
