<?php

namespace Volistx\Control\Connections;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Volistx\Control\Contracts\ProcessedResponse;
use Volistx\Control\Helpers\Messages;

class Subscription extends ModuleBase
{
    public function __construct(Client $client, string $user_id)
    {
        $this->module = 'subscriptions';
        $this->client = $client;
        $this->user_id = $user_id;
    }

    public function createSubscription(string $plan_id, DateTime $activated_at, DateTime $expires_at = null): ProcessedResponse
    {
        $inputs = [
            'user_id' => $this->user_id,
            'plan_id' => $plan_id,
            'activated_at' => $activated_at->format('Y-m-d H:i:s'),
            'expires_at' => $expires_at?->format('Y-m-d H:i:s'),
        ];

        $validator = $this->GetModuleValidation($this->module)->generateCreateValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->post("admin/users/{$this->user_id}/subscriptions", [
                'json' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function mutateSubscription(string $subscription_id, string $plan_id = null, string $status = null, DateTime $activated_at = null, DateTime $expires_at = null, DateTime $cancels_at = null, DateTime $cancelled_at = null): ProcessedResponse
    {
        $inputs = [
            'user_id' => $this->user_id,
            'subscription_id' => $subscription_id,
            'plan_id' => $plan_id,
            'status' => $status,
            'activated_at' => $activated_at?->format('Y-m-d H:i:s'),
            'expires_at' => $expires_at?->format('Y-m-d H:i:s'),
            'cancels_at' => $cancels_at?->format('Y-m-d H:i:s'),
            'cancelled_at' => $cancelled_at?->format('Y-m-d H:i:s'),
        ];

        $validator = $this->GetModuleValidation($this->module)->generateUpdateValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->put("admin/users/{$this->user_id}/subscriptions/{$subscription_id}/mutate", [
                'json' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function deleteSubscription(string $subscription_id): ProcessedResponse
    {
        $inputs = [
            'user_id' => $this->user_id,
            'subscription_id' => $subscription_id,
        ];

        $validator = $this->GetModuleValidation($this->module)->generateDeleteValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->delete("admin/users/{$this->user_id}/subscriptions/{$subscription_id}");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function cancelSubscription(string $subscription_id, DateTime $cancels_at): ProcessedResponse
    {
        $inputs = [
            'user_id' => $this->user_id,
            'subscription_id' => $subscription_id,
            'cancels_at' => $cancels_at?->format('Y-m-d H:i:s'),
        ];

        $validator = $this->GetModuleValidation($this->module)->generateCancelValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->put("admin/users/{$this->user_id}/subscriptions/{$subscription_id}/cancel", [
                'json' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function undoCancelSubscription(string $subscription_id): ProcessedResponse
    {
        $inputs = [
            'user_id' => $this->user_id,
            'subscription_id' => $subscription_id,
        ];

        $validator = $this->GetModuleValidation($this->module)->generateUncancelValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->put("admin/users/{$this->user_id}/subscriptions/{$subscription_id}/uncancel");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function getAllSubscriptions(string $search = null, int $page = 1, int $limit = 50): ProcessedResponse
    {
        $inputs = compact('search', 'page', 'limit');
        $validator = $this->GetModuleValidation($this->module)->generateGetAllValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/subscriptions", [
                'query' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function getSubscription(string $subscription_id): ProcessedResponse
    {
        $validator = $this->GetModuleValidation($this->module)->generateGetValidation([
            'user_id' => $this->user_id,
            'subscription_id' => $subscription_id,
        ]);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/subscriptions/{$subscription_id}");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function getSubscriptionLogs(string $subscription_id, string $search = null, int $page = 1, int $limit = 50): ProcessedResponse
    {
        $inputs = [
            'subscription_id' => $subscription_id,
            'search' => $search,
            'page' => $page,
            'limit' => $limit,
            'user_id' => $this->user_id,
        ];

        $validator = $this->GetModuleValidation($this->module)->generateGetLogsValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/subscriptions/{$subscription_id}/logs", [
                'query' => compact('search', 'page', 'limit'),
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function getSubscriptionUsages(string $subscription_id, string $search = null, int $page = 1, int $limit = 50): ProcessedResponse
    {
        $inputs = [
            'subscription_id' => $subscription_id,
            'search' => $search,
            'page' => $page,
            'limit' => $limit,
            'user_id' => $this->user_id,
        ];

        $validator = $this->GetModuleValidation($this->module)->generateGetUsageValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->get("admin/users/{$this->user_id}/subscriptions/{$subscription_id}/usages", [
                'query' => compact('search', 'page', 'limit'),
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }
}
