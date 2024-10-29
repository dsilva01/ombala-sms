<?php

namespace NotificationChannels\Ombala;

class OmbalaMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The sander name the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param  string  $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the from name the message should be sent from.
     *
     * @param  string  $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }
}
