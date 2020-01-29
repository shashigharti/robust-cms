<?php

namespace Robust\RealEstate\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


/**
 * Class SendEmailToLead
 * @package Robust\RealEstate\Events
 */
class SendEmailToLead
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var
     */
    public $lead;
    /**
     * @var
     */
    public $to;

    /**
     * @var
     */
    public $message;

    /**
     * @var
     */
    public $subject;


    /**
     * SendEmailToLead constructor.
     * @param $to
     * @param $subject
     * @param $message
     * @param $lead
     */
    public function __construct($to, $subject, $message, $lead)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->lead = $lead;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
