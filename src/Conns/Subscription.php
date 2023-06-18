<?php

namespace Volistx\Control\Conns;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Validator;
use Volistx\Control\Helpers\Messages;

class Subscription {
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createSubscription(string $user_id, string $plan_id, \DateTime $activated_at, \DateTime $expires_at = null)
    {
        $validator = Validator::make(
            [
                'user_id' => $user_id,
                'plan_id' => $plan_id,
                'activated_at' => $activated_at,
                'expires_at' => $expires_at
            ],
            [
                'user_id'      => ['bail', 'required', 'uuid'],
                'plan_id'      => ['bail', 'required', 'uuid'],
                'activated_at' => ['bail', 'required', 'date'],
                'expires_at'   => ['bail', 'present', 'date', 'nullable'],
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
                    'expires_at' => $expires_at?->format('Y-m-d H:i:s'),
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }
}