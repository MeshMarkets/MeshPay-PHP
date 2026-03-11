<?php

namespace MeshPay;

use GuzzleHttp\Client;

class AccountsResource
{
    public function __construct(private Client $client)
    {
    }

    public function create(string $email): array
    {
        $res = $this->client->post('/accounts', ['json' => ['email' => $email]]);
        return json_decode((string) $res->getBody(), true);
    }
}
