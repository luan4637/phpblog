<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = auth()->user();
 
            return response()
                    ->json($user)
                    ->header('Authorization', '');
        }
 
        return response()->json(['status' => 'fail']);
    }

    public function unauthenticate(Request $request)
    {
        return response()->json([
            'status' => 'fail',
            'message' => 'unauthenticate'
        ]);
    }
}