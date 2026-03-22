<?php

namespace MeshPay;

use GuzzleHttp\Client;

class ChargesResource
{
    public function __construct(private Client $client)
    {
    }

    /** @param array{limit?: int, cursor?: string, status?: string} $params */
    public function list(array $params = []): array
    {
        $res = $this->client->get('/charges', ['query' => array_filter($params)]);
        return json_decode((string) $res->getBody(), true);
    }

    public function get(string $chargeId): array
    {
        $res = $this->client->get("/charges/{$chargeId}");
        return json_decode((string) $res->getBody(), true);
    }

    /**
     * @param array<string, mixed> $body payee_membership_id, amount, optional payer_membership_id, buyer_id, currency
     */
    public function create(array $body, string $idempotencyKey): array
    {
        $res = $this->client->post('/charges', [
            'json' => $body,
            'headers' => ['Idempotency-Key' => $idempotencyKey],
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    /** @param array<string, mixed> $body */
    public function fund(string $chargeId, array $body, string $idempotencyKey): array
    {
        $res = $this->client->post("/charges/{$chargeId}/fund", [
            'json' => $body,
            'headers' => ['Idempotency-Key' => $idempotencyKey],
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    public function cancel(string $chargeId, string $idempotencyKey): array
    {
        $res = $this->client->post("/charges/{$chargeId}/cancel", [
            'json' => [],
            'headers' => ['Idempotency-Key' => $idempotencyKey],
        ]);
        return json_decode((string) $res->getBody(), true);
    }

    /** @param array<string, mixed> $body */
    public function refund(string $chargeId, array $body, string $idempotencyKey): array
    {
        $res = $this->client->post("/charges/{$chargeId}/refund", [
            'json' => $body,
            'headers' => ['Idempotency-Key' => $idempotencyKey],
        ]);
        return json_decode((string) $res->getBody(), true);
    }
}
