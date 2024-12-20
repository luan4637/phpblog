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
            'id' => 1,
            'name' => 'guest',
            'email' => 'guest@mail.com',
            'password' => 'guest'
        ]);
        
        $expire = date('Y-m-d H:i:s', strtotime("+1 hour"));
        $token = $user->createToken(env('APP_NAME'), ['*'], new DateTime($expire));

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
            // $request->session()->regenerate();
            
            /** @var string $expire */
            $expire = date('Y-m-d H:i:s', strtotime("+1 hour"));
            /** @var \App\Core\User\UserModel $user */
            $user = Auth::user();
            /** @var \Laravel\Sanctum\NewAccessToken $token */
            $token = $user->createToken(env('APP_NAME'), ['*'], new DateTime($expire));
            $user->token = $token->plainTextToken;
 
            return $this->responseSuccess($user);
        } else {
            return $this->responseFail('Invalid email or password!');
        }
 
        return $this->responseFail('Something went wrong!');
    }

    public function logout(Request $request)
    {
        return $this->responseSuccess(true);
    }
}