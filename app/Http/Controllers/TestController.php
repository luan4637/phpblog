<?php
namespace App\Http\Controllers;

use App\Core\User\UserModel;
use App\Core\User\UserRepositoryInterface;
use App\Events\MessagePushed;
use App\Notifications\PostCreated;
use ElephantIO\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{
    /** @var UserRepositoryInterface $userRepository */
    private UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // $user = UserModel::factory()->make([
        //     'name' => 'guest',
        //     'email' => 'guest@mail.com',
        //     'password' => 'guest',
        //     'email_verified_at' => now(),
        // ]);

        // var_dump($user);


        

        $users = $this->userRepository->getAll();
        $message = 'notify message: ' . date('Y-m-d H:i:s');

        // $user->notify(new PostCreated($message));
        Notification::send($users, new PostCreated($message));

        // $index = count($user->notifications);
        // foreach ($user->notifications as $notification) {
        //     if ($index + 5 > count($user->notifications)) {
        //         echo json_encode($notification->data) . ': ' . $notification->created_at. '<br />';
        //     }

        //     --$index;
        // }

        // $url = 'http://host.docker.internal:3000';
        // $options = ['client' => Client::CLIENT_4X];

        // $client = Client::create($url, $options);
        // $client->connect();
        // $client->of('/');
        // $client->emit('new message', [$message]);
        // $client->disconnect();

        // event(new MessagePushed($message));

        echo $message;
    }

    public function getCache(Request $request)
    {
        $value = Cache::get('keytest', 'empty');

        echo $value;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createToken(Request $request)
    {
        $user = $request->user();
        var_dump($user->email);
        die;
        $token = $user->createToken($request->token_name);
 
        return ['token' => $token->plainTextToken];
    }
}