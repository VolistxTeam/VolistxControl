<?php

namespace Volistx\Control\Conns;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Validator;
use Volistx\Control\Helpers\Messages;

/**
 * Class User
 * @package Volistx\Control\Conns
 */
class User
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * User constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create a user.
     *
     * @return array
     */
    public function createUser(): array
    {
        try {
            $response = $this->client->post('admin/users');

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    /**
     * Update a user.
     *
     * @param string $user_id
     * @param bool $is_active
     * @return array
     */
    public function updateUser(string $user_id, bool $is_active): array
    {
        $validator = Validator::make(
            [
                'user_id' => $user_id,
                'is_active' => $is_active
            ],
            [
                'user_id'   => ['bail', 'required', 'uuid'],
                'is_active' => ['bail', 'sometimes', 'boolean'],
            ]
        );

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->patch("admin/users/{$user_id}", [
                'json' => [
                    'is_active' => $is_active
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    /**
     * Delete a user.
     *
     * @param string $user_id
     * @return array
     */
    public function deleteUser(string $user_id): array
    {
        $validator = Validator::make(
            [
                'user_id' => $user_id,
            ],
            [
                'user_id' => ['bail', 'required', 'uuid'],
            ]
        );

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->delete("admin/users/{$user_id}");

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    /**
     * Get a user.
     *
     * @param string $user_id
     * @return array
     */
    public function getUser(string $user_id): array
    {
        $validator = Validator::make(
            [
                'user_id' => $user_id,
            ],
            [
                'user_id' => ['bail', 'required', 'uuid'],
            ]
        );

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->get("admin/users/{$user_id}");

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }
}
