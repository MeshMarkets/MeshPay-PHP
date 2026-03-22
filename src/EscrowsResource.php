<?php

namespace MeshPay;

use GuzzleHttp\Client;

class EscrowsResource
{
    public function __construct(private Client $client)
    {
    }

    /** @param array{limit?: int, status?: string} $params */
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

    public function release(string $escrowId, string $idempotencyKey): array
    {
        $res = $this->client->post("/escrows/{$escrowId}/release", [
            'json' => [],
            'headers' => ['Idempotency-Key' => $idempotencyKey],
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    public function openDispute(string $escrowId, string $txHash): array
    {
        $res = $this->client->post("/escrows/{$escrowId}/open-dispute", [
            'json' => ['tx_hash' => $txHash],
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    public function resolveDispute(string $escrowId, bool $releaseToSeller, string $idempotencyKey): array
    {
        $res = $this->client->post("/escrows/{$escrowId}/resolve-dispute", [
            'json' => ['release_to_seller' => $releaseToSeller],
            'headers' => ['Idempotency-Key' => $idempotencyKey],
        ]);
        return json_decode((string) $res->getBody(), true);
    }
}
