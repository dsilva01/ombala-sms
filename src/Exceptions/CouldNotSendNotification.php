<?php

namespace NotificationChannels\Ombala\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;

class CouldNotSendNotification extends Exception
{
    /**
     * Thrown when content length is greater than 918 characters.
     */
    public static function contentLengthLimitExceeded($count): self
    {
        return new self("Notification was not sent. Content length may not be greater than {$count} characters.", 422);
    }

    /**
     * Thrown when we're unable to communicate with ombala.
     */
    public static function ombalaRespondedWithAnError(ClientException $exception): self
    {
        if (! $exception->hasResponse()) {
            return new self('Ombala responded with an error but no response body found');
        }

        return new self("Ombala responded with an error '{$exception->getCode()} : {$exception->getMessage()}'", $exception->getCode(), $exception);
    }

    /**
     * Thrown when we're unable to communicate with ombala.
     */
    public static function couldNotCommunicateWithOmbala(Exception $exception): self
    {
        return new self("The communication with ombala failed. Reason: {$exception->getMessage()}", $exception->getCode(), $exception);
    }
}
