<?php

namespace Volistx\Control\Connections;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Volistx\Control\Helpers\Messages;
use Volistx\Validation\Traits\HasKernelValidations;

class Subscription {
    protected Client $client;
    protected string $module;
    protected string $user_id;

    use HasKernelValidations;

    public function __construct(Client $client, string $user_id)
    {
        $this->module = 'subscription';
        $this->client = $client;
        $this->user_id = $user_id;
    }

    public function create(string $plan_id, \DateTime $activated_at, \DateTime $expires_at = null)
    {
        $inputs = compact('plan_id', 'activated_at', 'expires_at');
        $inputs['user_id'] = $this->user_id;
        $validator = $this->GetModuleValidation($this->module)->generateCreateValidation($inputs);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->post("admin/users/{$this->user_id}/subscriptions", [
                'json' => [
                    'user_id' => $this->user_id,
                    'plan_id' => $plan_id,
                    'activated_at' => $activated_at->format('Y-m-d H:i:s'),
                    'expires_at' =>$expires_at?->format('Y-m-d H:i:s'),
                ],
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function mutate(string $subscription_id, string $plan_id = null, string $status = null, \DateTime $activated_at = null, \DateTime $expires_at = null, \DateTime $cancels_at = null, \DateTime $cancelled_at = null)
    {
        $inputs = compact('subscription_id', 'plan_id', 'status', 'activated_at', 'expires_at', 'cancels_at', 'cancelled_at');
        $inputs['user_id'] = $this->user_id;
        $validator = $this->GetModuleValidation($this->module)->generateUpdateValidation($inputs);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->put("admin/users/{$this->user_id}/subscriptions/{$subscription_id}/mutate", [
                'json' => $inputs,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function delete(string $subscription_id)
    {
        $inputs = compact('subscription_id');
        $inputs['user_id'] = $this->user_id;
        $validator = $this->GetModuleValidation($this->module)->generateDeleteValidation($inputs);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->delete("admin/users/{$this->user_id}/subscriptions/{$subscription_id}");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function cancel(string $subscription_id, \DateTime $cancels_at)
    {
        $inputs = compact('subscription_id', 'cancels_at');
        $inputs['user_id'] = $this->user_id;
        $validator = $this->GetModuleValidation($this->module)->generateCancelValidation($inputs);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->put("admin/users/{$this->user_id}/subscriptions/{$subscription_id}/cancel", [
                'json' => [
                    'cancels_at' => $cancels_at->format('Y-m-d H:i:s'),
                ],
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function uncancel(string $subscription_id)
    {
        $inputs = compact('subscription_id');
        $inputs['user_id'] = $this->user_id;
        $validator = $this->GetModuleValidation($this->module)->generateUncancelValidation($inputs);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->put("admin/users/{$this->user_id}/subscriptions/{$subscription_id}/uncancel");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function get(string $subscription_id)
    {
        $inputs = compact('subscription_id');
        $inputs['user_id'] = $this->user_id;
        $validator = $this->GetModuleValidation($this->module)->generateGetValidation($inputs);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/subscriptions/{$subscription_id}");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function getAll(string $search = '', int $page = 1, int $limit = 50)
    {
        $inputs = compact('search', 'page', 'limit');
        $inputs['user_id'] = $this->user_id;
        $validator = $this->GetModuleValidation($this->module)->generateGetAllValidation($inputs);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/subscriptions", [
                'query' => compact('search', 'page', 'limit'),
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function getLogs(string $subscription_id, string $search = '', int $page = 1, int $limit = 50)
    {
        $inputs = compact('subscription_id', 'search', 'page', 'limit');
        $inputs['user_id'] = $this->user_id;
        $validator = $this->GetModuleValidation($this->module)->generateGetLogsValidation($inputs);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/subscriptions/{$subscription_id}/logs", [
                'query' => compact('search', 'page', 'limit'),
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function getUsages(string $subscription_id, string $search = '', int $page = 1, int $limit = 50)
    {
        $inputs = compact('subscription_id', 'search', 'page', 'limit');
        $inputs['user_id'] = $this->user_id;
        $validator = $this->GetModuleValidation($this->module)->generateGetUsageValidation($inputs);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/subscriptions/{$subscription_id}/usages", [
                'query' => compact('search', 'page', 'limit'),
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }
}