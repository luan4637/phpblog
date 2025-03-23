<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Core\Post\PostModel;
use App\Core\User\UserModel;

class NewPost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var PostModel $postModel */
    public PostModel $postModel;

    /** @var UserModel $user */
    public UserModel $user;

    /**
     * @param PostModel $postModel
     * @param UserModel $user
     */
    public function __construct(PostModel $postModel, UserModel $user)
    {
        $this->postModel = $postModel;
        $this->user = $user;
    }

    /**
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('channel-name'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'postModel' => $this->postModel->toArray(),
            'loggedUser' => $this->user
        ];
    }
}
