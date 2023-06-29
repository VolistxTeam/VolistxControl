<?php

namespace Volistx\Control\Connections;

use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Volistx\Control\Helpers\Messages;

class PersonalToken extends ModuleBase
{
    public function __construct(Client $client, string $user_id)
    {
        $this->module = 'personal-tokens';
        $this->client = $client;
        $this->user_id = $user_id;
    }

    /**
     * @throws Exception|GuzzleException|RequestException
     */
    public function create(string $name, DateTime $expires_at, int $rate_limit_mode = null,
                           array  $permission = null, int $ip_rule = null, array $ip_range = null,
                           int    $country_rule = null, array $country_range = null, bool $disable_logging = null, string $hmac_token = null)
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
            'hmac_token' => $hmac_token
        ];

        $validator = $this->GetModuleValidation($this->module)->generateCreateValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->post("admin/users/{$this->user_id}/personal-tokens", [
                'json' => $inputs,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * @throws Exception|GuzzleException|RequestException
     */
    public function update(string $token_id, string $name = null, DateTime $expires_at = null, int $rate_limit_mode = null,
                           array  $permission = null, int $ip_rule = null, array $ip_range = null,
                           int    $country_rule = null, array $country_range = null, bool $disable_logging = null, string $hmac_token = null)
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
            'hmac_token' => $hmac_token
        ];

        $validator = $this->GetModuleValidation($this->module)->generateUpdateValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->put("admin/users/{$this->user_id}/personal-tokens/$token_id", [
                'json' => $inputs,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * @throws Exception|GuzzleException|RequestException
     */
    public function delete(string $token_id)
    {
        $inputs = [
            'user_id' => $this->user_id,
            'token_id' => $token_id
        ];

        $validator = $this->GetModuleValidation($this->module)->generateDeleteValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->delete("admin/users/{$this->user_id}/personal-tokens/$token_id");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * @throws Exception|GuzzleException|RequestException
     */
    public function reset(string $token_id)
    {
        $inputs = [
            'user_id' => $this->user_id,
            'token_id' => $token_id
        ];

        $validator = $this->GetModuleValidation($this->module)->generateResetValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->post("admin/users/{$this->user_id}/personal-tokens/$token_id/reset");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * @throws Exception|GuzzleException|RequestException
     */
    public function getAll(string $search = null, int $page = 1, int $limit = 50)
    {
        $inputs = compact('search', 'page', 'limit');
        $validator = $this->GetModuleValidation($this->module)->generateGetAllValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/personal-tokens", [
                'query' => $inputs,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * @throws Exception|GuzzleException|RequestException
     */
    public function get(string $token_id)
    {
        $validator = $this->GetModuleValidation($this->module)->generateGetValidation([
            'user_id' => $this->user_id,
            'token_id' => $token_id,
        ]);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/personal-tokens/$token_id");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * @throws Exception|GuzzleException|RequestException
     */
    public function sync(string $user_id)
    {
        $validator = $this->GetModuleValidation($this->module)->generateSyncValidation([
            'user_id' => $this->user_id,
        ]);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->post("admin/users/{$this->user_id}/personal-tokens/sync");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }
}