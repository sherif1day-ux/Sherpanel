<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Users/Index', [
            'users' => User::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('message', 'User created successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('message', 'User deleted successfully');
    }
}
