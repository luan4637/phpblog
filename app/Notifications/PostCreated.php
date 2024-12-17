<?php

namespace App\Notifications;

use App\Core\Post\PostModel;
use ElephantIO\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostCreated extends Notification
{
    use Queueable;

    /**
     * @var PostModel $postModel
     */
    public $postModel;

    /**
     * @param PostModel $postModel
     */
    public function __construct(PostModel $postModel)
    {
        $this->postModel = $postModel;
    }

    /**
     * @param object $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }

    /**
     * @param object $notifiable
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return $this->postModel->toArray();
    }

    /**
     * @param object $notifiable
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return 'post-created';
    }

    public function toBroadcast(object $notifiable): array
    {
        return array_merge(
            $this->postModel->toArray(),
            ['user_id' => $notifiable->id]
        );
    }
}
