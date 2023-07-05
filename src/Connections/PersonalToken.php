<?php

namespace Volistx\Control\Connections;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Volistx\Control\Contracts\ProcessedResponse;
use Volistx\Control\Helpers\Messages;

class PersonalToken extends ModuleBase
{
    public function __construct(Client $client, string $user_id)
    {
        $this->module = 'personal-tokens';
        $this->client = $client;
        $this->user_id = $user_id;
    }

    public function create(string $name, DateTime $expires_at, int $rate_limit_mode = null,
        array $permission = null, int $ip_rule = null, array $ip_range = null,
        int $country_rule = null, array $country_range = null, bool $disable_logging = null, string $hmac_token = null): ProcessedResponse
    {
        $inputs = [
            'user_id' => $this->user_id,
            'name' => $name,
            'expires_at' => $expires_at->format('Y-m-d H:i:s'),
            'rate_limit_mode' => $rate_limit_mode,
            'permission' => $permission,
            'ip_rule' => $ip_rule,
            'ip_range' => $ip_range,
            'country_rule' => $country_rule,
            'country_range' => $country_range,
            'disable_logging' => $disable_logging,
            'hmac_token' => $hmac_token,
        ];

        $this->SanitizeInputs($inputs);

        $validator = $this->GetModuleValidation($this->module)->generateCreateValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->post("admin/users/{$this->user_id}/personal-tokens", [
                'json' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function update(string $token_id, string $name = null, DateTime $expires_at = null, int $rate_limit_mode = null,
        array $permission = null, int $ip_rule = null, array $ip_range = null,
        int $country_rule = null, array $country_range = null, bool $disable_logging = null, string $hmac_token = null): ProcessedResponse
    {
        $inputs = [
            'user_id' => $this->user_id,
            'token_id' => $token_id,
            'name' => $name,
            'expires_at' => $expires_at?->format('Y-m-d H:i:s'),
            'rate_limit_mode' => $rate_limit_mode,
            'permission' => $permission,
            'ip_rule' => $ip_rule,
            'ip_range' => $ip_range,
            'country_rule' => $country_rule,
            'country_range' => $country_range,
            'disable_logging' => $disable_logging,
            'hmac_token' => $hmac_token,
        ];

        $this->SanitizeInputs($inputs);

        $validator = $this->GetModuleValidation($this->module)->generateUpdateValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->put("admin/users/{$this->user_id}/personal-tokens/$token_id", [
                'json' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function delete(string $token_id): ProcessedResponse
    {
        $inputs = [
            'user_id' => $this->user_id,
            'token_id' => $token_id,
        ];

        $validator = $this->GetModuleValidation($this->module)->generateDeleteValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->delete("admin/users/{$this->user_id}/personal-tokens/$token_id");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function reset(string $token_id): ProcessedResponse
    {
        $inputs = [
            'user_id' => $this->user_id,
            'token_id' => $token_id,
        ];

        $validator = $this->GetModuleValidation($this->module)->generateResetValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->post("admin/users/{$this->user_id}/personal-tokens/$token_id/reset");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function getAll(string $search = null, int $page = 1, int $limit = 50): ProcessedResponse
    {
        $inputs = compact('search', 'page', 'limit');
        $validator = $this->GetModuleValidation($this->module)->generateGetAllValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/personal-tokens", [
                'query' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function get(string $token_id): ProcessedResponse
    {
        $validator = $this->GetModuleValidation($this->module)->generateGetValidation([
            'user_id' => $this->user_id,
            'token_id' => $token_id,
        ]);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/personal-tokens/$token_id");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function sync(string $user_id): ProcessedResponse
    {
        $validator = $this->GetModuleValidation($this->module)->generateSyncValidation([
            'user_id' => $this->user_id,
        ]);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->post("admin/users/{$this->user_id}/personal-tokens/sync");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }
}
