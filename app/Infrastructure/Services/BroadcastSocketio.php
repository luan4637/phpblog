<?php
namespace App\Infrastructure\Services;

use ElephantIO\Client;
use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BroadcastSocketio extends Broadcaster
{
    private $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function auth($request)
    {

    }

    public function validAuthenticationResponse($request, $result)
    {

    }

    public function broadcast(array $channels, $event, array $payload = [])
    {
        $url = $this->settings['socket_url'];
        $options = [
            'client' => $this->settings['options']['client_version']
        ];

        $client = Client::create($url, $options);
        $client->connect();
        // $client->of('/');
        // $client->emit('new message', [json_encode($payload)]);
        // var_dump($channels, $event, $payload);

        try {
            foreach($channels as $channel) {
                $channelName = $channel->name;
                
                if (strripos($channelName, '.') > -1) {
                    $channelName = substr($channelName, 0, strripos($channelName, '.'));
                }
                
                $client->emit($channelName, $payload);
            }
        } catch (\Exception $e) {
            throw new BroadcastException(
                sprintf('Socket io error: %s.', $e->getMessage())
            );
        }

        $client->disconnect();
    }
}