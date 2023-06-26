<?php

namespace Volistx\Control\Connections;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Status
 * @package Volistx\Control\Connections
 */
class Status
{

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * Status constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Ping the server.
     *
     * @return array|null
     * @throws Exception|GuzzleException|RequestException
     */
    public function ping(): ?array
    {
        try {
            $request = $this->client->get('ping');

            return json_decode($request->getBody()->getContents(), true);
        } catch (Exception) {
            return null;
        }
    }

    /**
     * Get server timestamp.
     *
     * @return string|null
     * @throws Exception|GuzzleException|RequestException
     */
    public function timestamp(): ?string
    {
        try {
            $request = $this->client->get('timestamp');

            return $request->getBody()->getContents();
        } catch (Exception) {
            return null;
        }
    }
}
