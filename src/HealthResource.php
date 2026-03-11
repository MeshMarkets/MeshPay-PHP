<?php

namespace MeshPay;

use GuzzleHttp\Client;

class HealthResource
{
    public function __construct(private Client $client)
    {
    }

    public function get(): array
    {
        $res = $this->client->get('/health');
        return json_decode((string) $res->getBody(), true) ?? [];
    }
}
