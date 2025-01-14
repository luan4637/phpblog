<?php
namespace App\Http\Controllers;

use App\Core\Post\PostModel;
use App\Core\Post\PostRepositoryInterface;
use App\Core\User\UserModel;
use App\Core\User\UserRepositoryInterface;
use App\Events\MessagePushed;
use App\Jobs\ProcessPodcast;
use App\Notifications\PostCreated;
use ElephantIO\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    /** @var UserRepositoryInterface $userRepository */
    private UserRepositoryInterface $userRepository;

    private PostRepositoryInterface $postRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        PostRepositoryInterface $postRepository
    ) {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
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


        // ProcessPodcast::dispatch()->onQueue('default');
        ProcessPodcast::dispatch();
        

        $users = $this->userRepository->getAll();
        $userAdmin = $this->userRepository->find(2);
        $message = 'notify message: ' . date('Y-m-d H:i:s');
        $post = $this->postRepository->find(135);
        // $userAdmin->notify(new PostCreated($post));

        // $user->notify(new PostCreated($message));
        // Notification::send($users, new PostCreated($message));

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

    public function files(Request $request)
    {
        
        // $client = new S3Client([
        //     'version' => 'latest',
        //     'region' => 'us-west-2',
        //     'endpoint' => 'http://host.docker.internal:4566',
        //     // 'bucket_endpoint' => true,
        //     // 'endpoint' => 'http://s3.localhost.localstack.cloud:4566',
        //     'use_path_style_endpoint' => true,
        //     'credentials' => [
        //         'key' => 'admin',
        //         'secret' => 'admin'
        //     ]
        // ]);
        // $bucketName = 'phpblogbucket';
        // $fileName = 'test.jpg';
        // $sourceFile = app_path() . '/../public/upload/5f9bbcb2febc89269fd81bdd4846ea02.jpg';

        // try {
        //     $client->createBucket([
        //         'Bucket' => $bucketName,
        //     ]);
        //     echo "Created bucket named: $bucketName \n";
        // } catch (\Exception $exception) {
        //     echo "Failed to create bucket $bucketName with error: " . $exception->getMessage();
        //     exit("Please fix error with bucket creation before continuing.");
        // }

        // try {
        //     $client->putObject([
        //         'Bucket' => $bucketName,
        //         'Key' => $fileName,
        //         'SourceFile' => $sourceFile
        //     ]);
        //     echo "Uploaded $fileName to $bucketName.\n";
        // } catch (\Exception $exception) {
        //     echo "Failed to upload $fileName with error: " . $exception->getMessage();
        //     exit("Please fix error with file upload before continuing.");
        // }

        $sourceFile = app_path() . '/../public/upload/5f9bbcb2febc89269fd81bdd4846ea02.jpg';
        Storage::put('test3.jpg', file_get_contents($sourceFile));

        // $url = Storage::url('test.jpg');
        // echo $url;

        echo 'func files';
    }

    public function getCache(Request $request)
    {
        $value = Cache::get('keytest', 'empty');

        return $this->responseFail($value);
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

    public function sendMessageQueue(Request $request)
    {
        $connection = new AMQPStreamConnection('host.docker.internal', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        $msg = new AMQPMessage('Hello World 111!');
        $channel->basic_publish($msg, '', 'hello');

        echo " [x] Sent 'Hello World!'\n";  
    }
}