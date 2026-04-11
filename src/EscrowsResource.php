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

    /** @param array<string, mixed> $body contributor_membership_id, amount */
    public function createContribution(string $escrowId, array $body, string $idempotencyKey): array
    {
        $res = $this->client->post("/escrows/{$escrowId}/contributions", [
            'json' => $body,
            'headers' => ['Idempotency-Key' => $idempotencyKey],
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    /** @param array<string, mixed> $body payee_membership_id */
    public function setPayee(string $escrowId, array $body, string $idempotencyKey): array
    {
        $res = $this->client->post("/escrows/{$escrowId}/set-payee", [
            'json' => $body,
            'headers' => ['Idempotency-Key' => $idempotencyKey],
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    public function cancelPooledEscrow(string $escrowId, string $idempotencyKey): array
    {
        $res = $this->client->post("/escrows/{$escrowId}/cancel-pool", [
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
