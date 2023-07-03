<?php

namespace Volistx\Control\Connections;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Volistx\Control\Contracts\ProcessedResponse;
use Volistx\Control\Helpers\Messages;

class AdminLog extends ModuleBase
{
    public function __construct(Client $client)
    {
        $this->module = 'admin-logs';
        $this->client = $client;
    }

    public function getAllLogs(string $search = null, int $page = 1, int $limit = 50): ProcessedResponse
    {
        $inputs = compact('search', 'page', 'limit');
        $validator = $this->GetModuleValidation($this->module)->generateGetAllValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->get('admin/logs', [
                'query' => $inputs,
            ]);

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }

    public function getLog(string $log_id): ProcessedResponse
    {
        $inputs = compact('log_id');

        $validator = $this->GetModuleValidation($this->module)->generateGetValidation($inputs);

        if ($validator->fails()) {
            return (new ProcessedResponse())->invalidate(400, Messages::E400($validator->errors()->first()));
        }

        try {
            $response = $this->client->get("admin/logs/$log_id");

            return new ProcessedResponse($response);
        } catch (ClientException|GuzzleException $ex) {
            return new ProcessedResponse($ex);
        }
    }
}
