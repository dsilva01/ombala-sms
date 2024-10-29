<?php

namespace NotificationChannels\Ombala;

use Illuminate\Notifications\Notification;
use NotificationChannels\Ombala\Exceptions\CouldNotSendNotification;

class OmbalaChannel
{
    /**
     * The Ombala client instance.
     */
    protected OmbalaApi $ombala;

    /**
     * The phone number notifications should be sent from.
     */
    protected string $from;

    /**
     * The message body content count should be no longer than 6 message parts(918).
     */
    protected int $character_limit_count = 918;

    public function __construct(OmbalaApi $ombala, $from)
    {
        $this->ombala = $ombala;
        $this->from = $from;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @return mixed|\Psr\Http\Message\ResponseInterface|void
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('ombala', $notification)) {
            return;
        }

        /* @phpstan-ignore-next-line */
        $message = $notification->toOmbala($notifiable);

        if (is_string($message)) {
            $message = new OmbalaMessage($message);
        }

        if (mb_strlen($message->content) > $this->character_limit_count) {
            throw CouldNotSendNotification::contentLengthLimitExceeded($this->character_limit_count);
        }

        return $this->ombala->send([
            'from' => $message->from ?: $this->from,
            'to' => $to,
            'message' => trim($message->content),
        ]);
    }
}
