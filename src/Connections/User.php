<?php

namespace Volistx\Control\Connections;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Volistx\Control\Contracts\ProcessedResponse;
use Volistx\Control\Helpers\Messages;
use Volistx\Validation\Traits\HasKernelValidations;

/**
 * Class User
 */
class User extends ModuleBase
{
    use HasKernelValidations;

    public function __construct($client)
    {
        $this->client = $client;
        $this->module = 'user';
    }

    /**
     * Create a user.
     */
    public function createUser(string $user_id = null): ProcessedResponse
    {
        $inputs = compact('user_id');
        $this->SanitizeInputs($inputs);

        $validator = $this->GetModuleValidation($this->module)->generateCreateValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->post('admin/users', [
                'json' => [
                    'user_id' => $user_id,
                ],
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    /**
     * Update a user.
     */
    public function updateUser(string $user_id, bool $is_active): ProcessedResponse
    {
        $inputs = compact('user_id', 'is_active');
        $validator = $this->GetModuleValidation($this->module)->generateUpdateValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->patch("admin/users/{$user_id}", [
                'json' => [
                    'is_active' => $is_active,
                ],
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    /**
     * Delete a user.
     */
    public function deleteUser(string $user_id): ProcessedResponse
    {
        $inputs = compact('user_id');
        $validator = $this->GetModuleValidation($this->module)->generateDeleteValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->delete("admin/users/{$user_id}");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    /**
     * Get a user.
     */
    public function getUser(string $user_id): ProcessedResponse
    {
        $inputs = compact('user_id');
        $validator = $this->GetModuleValidation($this->module)->generateGetValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->get("admin/users/{$user_id}");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }
}
