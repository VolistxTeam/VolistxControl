<?php

namespace Volistx\Control\Connections;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Validator;
use Volistx\Control\Helpers\Messages;

class Subscription {
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(string $user_id, string $plan_id, \DateTime $activated_at, \DateTime $expires_at = null)
    {
        $validator = Validator::make(
            compact('user_id', 'plan_id', 'activated_at', 'expires_at'),
            [
                'user_id'      => ['bail', 'required', 'uuid'],
                'plan_id'      => ['bail', 'required', 'uuid'],
                'activated_at' => ['bail', 'required', 'date'],
                'expires_at'   => ['bail', 'nullable', 'date'],
            ]
        );

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->post("admin/users/$user_id/subscriptions", [
                'json' => [
                    'user_id' => $user_id,
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

    public function mutate(string $user_id, string $subscription_id, string $plan_id = null, string $status = null, \DateTime $activated_at = null, \DateTime $expires_at = null, \DateTime $cancels_at = null, \DateTime $cancelled_at = null)
    {
        $requestData = compact('subscription_id', 'user_id', 'plan_id', 'status', 'activated_at', 'expires_at', 'cancels_at', 'cancelled_at');

        $validator = Validator::make($requestData, [
            'subscription_id' => ['bail', 'required', 'uuid'],
            'user_id' => ['bail', 'required', 'uuid'],
            'plan_id' => ['bail', 'nullable', 'uuid'],
            'status' => ['bail', 'nullable'],
            'activated_at' => ['bail', 'nullable', 'date'],
            'expires_at' => ['bail', 'nullable', 'date'],
            'cancels_at' => ['bail', 'nullable', 'date'],
            'cancelled_at' => ['bail', 'nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->put("admin/users/$user_id/subscriptions/$subscription_id/mutate", [
                'json' => $requestData,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function delete(string $user_id, string $subscription_id)
    {
        $validator = Validator::make([
            'subscription_id' => $subscription_id,
            'user_id' => $user_id,
        ], [
            'subscription_id' => ['bail', 'required', 'uuid'],
            'user_id' => ['bail', 'required', 'uuid'],
        ]);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->delete("admin/users/$user_id/subscriptions/$subscription_id");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function cancel(string $user_id, string $subscription_id, \DateTime $cancels_at)
    {
        $validator = Validator::make([
            'user_id' => $user_id,
            'subscription_id' => $subscription_id,
            'cancels_at' => $cancels_at,
        ], [
            'subscription_id' => ['bail', 'required', 'uuid'],
            'user_id' => ['bail', 'required', 'uuid'],
            'cancels_at' => ['bail', 'nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->put("admin/users/$user_id/subscriptions/$subscription_id/cancel", [
                'json' => [
                    'cancels_at' => $cancels_at->format('Y-m-d H:i:s'),
                ],
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function uncancel(string $user_id, string $subscription_id)
    {
        $validator = Validator::make([
            'user_id' => $user_id,
            'subscription_id' => $subscription_id,
        ], [
            'subscription_id' => ['bail', 'required', 'uuid'],
            'user_id' => ['bail', 'required', 'uuid'],
        ]);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->put("admin/users/$user_id/subscriptions/$subscription_id/uncancel");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function get(string $user_id, string $subscription_id)
    {
        $validator = Validator::make([
            'user_id' => $user_id,
            'subscription_id' => $subscription_id,
        ], [
            'subscription_id' => ['bail', 'required', 'uuid'],
            'user_id' => ['bail', 'required', 'uuid'],
        ]);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->get("admin/users/$user_id/subscriptions/$subscription_id");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function getAll(string $user_id, string $search = '', int $page = 1, int $limit = 50)
    {
        $validator = Validator::make([
            'user_id' => $user_id,
            'search' => $search,
            'page' => $page,
            'limit' => $limit,
        ], [
            'user_id' => ['bail', 'required', 'uuid'],
            'search' => ['bail', 'nullable'],
            'page' => ['bail', 'nullable', 'integer'],
            'limit' => ['bail', 'nullable', 'integer'],
        ]);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->get("admin/users/$user_id/subscriptions", [
                'query' => compact('search', 'page', 'limit'),
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function getLogs(string $user_id, string $subscription_id, string $search = '', int $page = 1, int $limit = 50)
    {
        $validator = Validator::make([
            'user_id' => $user_id,
            'subscription_id' => $subscription_id,
            'search' => $search,
            'page' => $page,
            'limit' => $limit,
        ], [
            'subscription_id' => ['bail', 'required', 'uuid'],
            'user_id' => ['bail', 'required', 'uuid'],
            'search' => ['bail', 'nullable'],
            'page' => ['bail', 'nullable', 'integer'],
            'limit' => ['bail', 'nullable', 'integer'],
        ]);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->get("admin/users/$user_id/subscriptions/$subscription_id/logs", [
                'query' => compact('search', 'page', 'limit'),
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function getUsages(string $user_id, string $subscription_id)
    {
        $validator = Validator::make([
            'user_id' => $user_id,
            'subscription_id' => $subscription_id,
        ], [
            'subscription_id' => ['bail', 'required', 'uuid'],
            'user_id' => ['bail', 'required', 'uuid'],
        ]);

        if ($validator->fails()) {
            return Messages::E400($validator->errors()->first());
        }

        try {
            $response = $this->client->get("admin/users/$user_id/subscriptions/$subscription_id/usages");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }
}
