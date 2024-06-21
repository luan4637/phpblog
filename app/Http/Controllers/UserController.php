<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $check = Auth::check();

        return response()->json([
            'id' => $id,
            'check' => $check
        ]);
    }
}