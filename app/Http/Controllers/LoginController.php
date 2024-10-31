<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Core\User\UserModel;
use DateTime;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        /** @var UserModel $user */
        $user = new UserModel();
        $user->fill([
            'id' => 10,
            'name' => 'guest',
            'email' => 'guest1@mail.com',
            'password' => 'guest'
        ]);
        
        $expire = date('Y-m-d H:i:s', strtotime("+1 hour"));
        $token = $user->createToken('MyApp', ['*'], new DateTime($expire));

        if ($token) {
            return $this->responseSuccess(['token' => $token->plainTextToken]);
        }
        
        return $this->responseFail('Cannot create guest user');
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

    public function logout(Request $request)
    {
        return $this->responseSuccess(true);
    }
}