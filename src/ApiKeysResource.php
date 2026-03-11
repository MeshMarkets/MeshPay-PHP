<?php

namespace MeshPay;

use GuzzleHttp\Client;

class ApiKeysResource
{
    public function __construct(private Client $client)
    {
    }

    /** @return array<int, array> */
    public function list(): array
    {
        $res = $this->client->get('/api-keys');
        return json_decode((string) $res->getBody(), true) ?? [];
    }

    public function create(?string $name = null): array
    {
        $body = $name !== null ? ['name' => $name] : [];
        $res = $this->client->post('/api-keys', ['json' => $body]);
        return json_decode((string) $res->getBody(), true);
    }

    public function delete(string $id): void
    {
        $this->client->delete("/api-keys/{$id}");
    }
}
