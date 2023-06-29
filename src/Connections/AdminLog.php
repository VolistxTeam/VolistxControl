<?php

namespace Volistx\Control\Connections;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Volistx\Control\Helpers\Messages;

class AdminLog extends ModuleBase
{
    public function __construct(Client $client, string $user_id)
    {
        $this->module = 'admin-logs';
        $this->client = $client;
        $this->user_id = $user_id;
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
            $response = $this->client->get("admin/logs", [
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
    public function get(string $log_id)
    {
        $inputs = compact('log_id');

        $validator = $this->GetModuleValidation($this->module)->generateGetValidation($inputs);

        if ($validator->fails()) {
            throw new Exception(json_encode(Messages::E400($validator->errors()->first())));
        }

        try {
            $response = $this->client->get("admin/logs/$log_id");

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw new Exception($e->getResponse()->getBody()->getContents());
        }
    }
}