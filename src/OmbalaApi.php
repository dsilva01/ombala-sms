<?php

namespace NotificationChannels\Ombala;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use NotificationChannels\Ombala\Exceptions\CouldNotSendNotification;

class OmbalaApi
{
    protected HttpClient $client;

    protected string $endpoint;

    protected string $from;

    protected mixed $token;

    public function __construct($token = null, $httpClient = null)
    {
        $this->token = $token;
        $this->client = $httpClient;

        $this->endpoint = config('services.ombala.endpoint', 'https://api.useombala.ao/v1/messages');
    }

    /**
     * Send text message.
     *
     * <code>
     * $message = [
     *   'from'   => '',
     *   'to'       => '',
     *   'message'  => '',
     *   'test'     => '',
     * ];
     * </code>
     *
     * @link https://developer.useombala.ao/
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws CouldNotSendNotification
     */
    public function send(array $message)
    {
        try {
            $response = $this->client->request('POST', $this->endpoint, [
                'headers' => [
                    'Authorization' => "Token {$this->token}",
                    'Content-Type' => "application/json",
                ],
                'json' => [
                    'from' => Arr::get($message, 'from'),
                    'to' => Arr::get($message, 'to'),
                    'message' => Arr::get($message, 'message'),
                ],
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $e) {
            throw CouldNotSendNotification::ombalaRespondedWithAnError($e);
        } catch (GuzzleException $e) {
            throw CouldNotSendNotification::couldNotCommunicateWithOmbala($e);
        }
    }
}
