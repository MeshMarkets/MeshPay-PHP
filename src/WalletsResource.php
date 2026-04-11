<?php

namespace MeshPay;

use GuzzleHttp\Client;

class WalletsResource
{
    public function __construct(private Client $client)
    {
    }

    public function list(): array
    {
        $res = $this->client->get('/wallets');
        return json_decode((string) $res->getBody(), true);
    }

    /** @param array{network?: string} $query */
    public function getDetail(string $membershipId, array $query = []): array
    {
        $res = $this->client->get("/wallets/{$membershipId}", ['query' => array_filter($query)]);
        return json_decode((string) $res->getBody(), true);
    }
}
