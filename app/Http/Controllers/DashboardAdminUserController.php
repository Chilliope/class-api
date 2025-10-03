<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardAdminUserController extends Controller
{
    // GET /api/v1/user
    public function index()
    {
        $users = User::where('role', 'member')->get();

        return response()->json([
            'status' => 'ok',
            'data' => $users
        ], 200);
    }

    // GET /api/v1/user/{id}
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        return response()->json($user);
    }

    // POST /api/v1/user
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            'role'      => 'required|in:member,lead'
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'image'     => $request->image ?? 'default.jpg'
        ]);

        return response()->json([
            'message' => 'stored',
            'data' => $user
        ], 201);
    }

    // PUT /api/v1/user/{id}
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $request->validate([
            'firstname' => 'sometimes|required|string|max:255',
            'lastname'  => 'sometimes|required|string|max:255',
            'email'     => 'sometimes|required|email|unique:users,email,' . $id,
            'password'  => 'nullable|min:6',
            'role'      => 'sometimes|required|in:member,lead'
        ]);

        $user->update([
            'firstname' => $request->firstname ?? $user->firstname,
            'lastname'  => $request->lastname ?? $user->lastname,
            'email'     => $request->email ?? $user->email,
            'password'  => $request->password ? Hash::make($request->password) : $user->password,
            'role'      => $request->role ?? $user->role,
            'image'     => $request->image ?? $user->image
        ]);

        return response()->json([
            'message' => 'updated',
            'data' => $user
        ]);
    }

    // DELETE /api/v1/user/{id}
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'destroyed'
        ]);
    }
}
