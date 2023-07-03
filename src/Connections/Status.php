<?php

namespace Volistx\Control\Connections;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Volistx\Control\Contracts\ProcessedResponse;

/**
 * Class Status
 */
class Status
{
    protected Client $client;

    /**
     * Status constructor.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Ping the server.
     *
     * @throws Exception|GuzzleException|RequestException
     */
    public function ping(): ProcessedResponse
    {
        try {
            $response = $this->client->get('ping');

            return new ProcessedResponse($response);
        } catch (Exception $ex) {
            return new ProcessedResponse($ex);
        }
    }

    /**
     * Get server timestamp.
     *
     * @throws Exception|GuzzleException|RequestException
     */
    public function timestamp(): ProcessedResponse
    {
        try {
            $response = $this->client->get('timestamp');

            return new ProcessedResponse($response);
        } catch (Exception $ex) {
            return new ProcessedResponse($ex);
        }
    }
}
