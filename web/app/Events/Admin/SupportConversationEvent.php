<?php

namespace App\Events\Admin;

use App\Models\UserSupportTicket;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupportConversationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $support_ticket;
    public $conversation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserSupportTicket $support_ticket,$conversation)
    {
        $this->support_ticket = $support_ticket;
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ["support.conversation.".$this->support_ticket->token];
    }


    public function broadcastAs()
    {
        return 'support-conversation';
    }
}
