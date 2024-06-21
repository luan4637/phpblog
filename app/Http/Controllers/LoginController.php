<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
 
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = auth()->user();
            $user->token = $user->createToken('MyApp')->plainTextToken;
 
            return response()->json($user);
        }
 
        return response()->json(['status' => 'fail']);

        // if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
        //     $user = Auth::user(); 
        //     $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
        //     $success['name'] =  $user->name;
   
        //     return $this->sendResponse($success, 'User login successfully.');
        // } else { 
        //     return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        // } 
    }

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
}