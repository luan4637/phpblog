<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class LoginController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Core\User\UserModel $user */
        $user = auth()->user();

        if ($user) {
            return $this->responseSuccess($user);
        }
        
        return $this->responseFail('User does not found');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            /** @var \App\Core\User\UserModel $user */
            $user = auth()->user();
            $user->token = $user->createToken('MyApp')->plainTextToken;
 
            return $this->responseSuccess($user);
        }
 
        return $this->responseFail('Something went wrong!');
    }
}