<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlaceBidEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomId;
    public $createdAt, $endTime, $lastBidder, $lastBidderName, $bidAmount, $currentPrice, $currentBalance;

    /**
     * Create a new event instance.
     */
    public function __construct($roomId, $createdAt, $endTime, $lastBidder, $lastBidderName, $bidAmount, $currentPrice, $currentBalance)
    {
        $this->roomId = $roomId;
        $this->createdAt = $createdAt;
        $this->endTime = $endTime;
        $this->lastBidder = $lastBidder;
        $this->lastBidderName = $lastBidderName;
        $this->bidAmount = $bidAmount;
        $this->currentPrice = $currentPrice;
        $this->currentBalance = $currentBalance;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('room.' . $this->roomId);
    }
}
