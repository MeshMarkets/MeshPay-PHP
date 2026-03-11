<?php

namespace MeshPay;

use GuzzleHttp\Client;

class WalletsResource
{
    public function __construct(private Client $client)
    {
    }

    public function create(string $accountId): array
    {
        $res = $this->client->post('/wallets', ['json' => ['account_id' => $accountId]]);
        return json_decode((string) $res->getBody(), true);
    }

    public function getByAccountId(string $accountId): array
    {
        $res = $this->client->get('/wallets', ['query' => ['account_id' => $accountId]]);
        return json_decode((string) $res->getBody(), true);
    }
}
