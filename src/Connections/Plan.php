<?php

namespace Volistx\Control\Connections;

use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Volistx\Control\Contracts\ProcessedResponse;
use Volistx\Control\Helpers\Messages;

class Plan extends ModuleBase
{
    public function __construct(Client $client)
    {
        $this->module = 'plans';
        $this->client = $client;
    }

    public function create(string $name, string $tag, string $description, array $data, float $price, int $tier, string $custom): ProcessedResponse
    {
        $inputs = [
            'name' => $name,
            'tag' => $tag,
            'description' => $description,
            'data' => $data,
            'price' => $price,
            'tier' => $tier,
            'custom' => $custom,
        ];

        $validator = $this->GetModuleValidation($this->module)->generateCreateValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->post("admin/plans", [
                'json' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function update(string $plan_id, string $name = null, string $tag = null, string $description = null, array $data = null, float $price = null, int $tier = null, string $custom = null, bool $is_active = null): ProcessedResponse
    {
        $inputs = [
            'plan_id' => $plan_id,
            'name' => $name,
            'tag' => $tag,
            'description' => $description,
            'data' => $data,
            'price' => $price,
            'tier' => $tier,
            'custom' => $custom,
            'is_active' => $is_active
        ];

        $validator = $this->GetModuleValidation($this->module)->generateUpdateValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->put("admin/plans/$plan_id", [
                'json' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function delete(string $plan_id): ProcessedResponse
    {
        $inputs = compact('plan_id');

        $validator = $this->GetModuleValidation($this->module)->generateDeleteValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->delete("admin/plans/$plan_id");

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
            return new ProcessedResponse(null, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->get("admin/plans", [
                'query' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    /**
     * @throws Exception|RequestException
     */
    public function get(string $plan_id): ProcessedResponse
    {
        $inputs = compact('plan_id');

        $validator = $this->GetModuleValidation($this->module)->generateGetValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->get("admin/plans/$plan_id");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }
}
