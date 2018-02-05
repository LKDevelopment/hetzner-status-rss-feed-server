<?php

namespace App\Events;

use App\StatusMeldung;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewStatusMeldungArrived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $meldung;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(StatusMeldung $meldung)
    {
        $this->meldung = $meldung;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

    }
}
