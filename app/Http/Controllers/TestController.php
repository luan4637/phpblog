<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\User\UserModel;

class TestController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = UserModel::factory()->make([
            'name' => 'guest',
            'email' => 'guest@mail.com',
            'password' => 'guest',
            'email_verified_at' => now(),
        ]);

        var_dump($user);

        echo 'test';
    }
}