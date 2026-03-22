<?php

namespace MeshPay;

use GuzzleHttp\Client;

class AccountsResource
{
    public function __construct(private Client $client)
    {
    }

    public function list(): array
    {
        $res = $this->client->get('/accounts');
        return json_decode((string) $res->getBody(), true);
    }

    public function create(string $email): array
    {
        $res = $this->client->post('/accounts', ['json' => ['email' => $email]]);
        return json_decode((string) $res->getBody(), true);
    }

    public function deleteMembership(string $membershipId): void
    {
        $this->client->delete("/accounts/{$membershipId}");
    }
}
