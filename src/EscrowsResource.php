<?php

namespace MeshPay;

use GuzzleHttp\Client;

class EscrowsResource
{
    public function __construct(private Client $client)
    {
    }

    /** @param array{limit?: int, cursor?: string, status?: string} $params */
    public function list(array $params = []): array
    {
        $res = $this->client->get('/escrows', ['query' => array_filter($params)]);
        return json_decode((string) $res->getBody(), true);
    }

    public function get(string $escrowId): array
    {
        $res = $this->client->get("/escrows/{$escrowId}");
        return json_decode((string) $res->getBody(), true);
    }

    public function release(string $escrowId, ?string $idempotencyKey = null): array
    {
        $opts = ['json' => []];
        if ($idempotencyKey !== null) {
            $opts['headers'] = ['Idempotency-Key' => $idempotencyKey];
        }
        $res = $this->client->post("/escrows/{$escrowId}/release", $opts);
        return json_decode((string) $res->getBody(), true);
    }
}
