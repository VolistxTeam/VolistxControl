<?php

namespace Volistx\Control\Connections;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Volistx\Control\Helpers\Messages;
use Volistx\Validation\Traits\HasKernelValidations;

/**
 * Class User
 * @package Volistx\Control\Connections
 */
class User
{
    /**
     * @var Client
     */
    protected Client $client;
    protected string $module;

    use HasKernelValidations;

    /**
     * User constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->module = 'user';
    }

    /**
     * Create a user.
     *
     * @param string|null $user_id
     * @return array
     * @throws Exception|GuzzleException|RequestException
     */
    public function createUser(string $user_id = null): array
    {
        $inputs = compact('user_id');
        $validator = $this->GetModuleValidation($this->module)->generateCreateValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->post("admin/users", [
                'json' => [
                    'user_id' => $user_id
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * Update a user.
     *
     * @param string $user_id
     * @param bool $is_active
     * @return array
     * @throws Exception|GuzzleException|RequestException
     */
    public function updateUser(string $user_id, bool $is_active): array
    {
        $inputs = compact('user_id', 'is_active');
        $validator = $this->GetModuleValidation($this->module)->generateUpdateValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->patch("admin/users/{$user_id}", [
                'json' => [
                    'is_active' => $is_active
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * Delete a user.
     *
     * @param string $user_id
     * @return bool|array
     * @throws Exception|GuzzleException|RequestException
     */
    public function deleteUser(string $user_id): bool|array
    {
        $inputs = compact('user_id');
        $validator = $this->GetModuleValidation($this->module)->generateDeleteValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $this->client->delete("admin/users/{$user_id}");

            return true;
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * @param string $user_id
     * @return UserModule
     * @throws Exception|GuzzleException|RequestException
     */
    public function getUser(string $user_id): UserModule
    {
        $inputs = compact('user_id');
        $validator = $this->GetModuleValidation($this->module)->generateGetValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->get("admin/users/{$user_id}");

            $responseArray = json_decode($response->getBody()->getContents(), true);

            return new UserModule($this->client, $responseArray['id'], $responseArray['is_active']);
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }
}
