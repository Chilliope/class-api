<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardAdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'member')->get();

        return response()->json([
            'status' => 'ok',
            'data' => $users
        ], 200);
    }
}
