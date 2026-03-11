<?php

namespace MeshPay;

use GuzzleHttp\Client;

class PayoutsResource
{
    public function __construct(private Client $client)
    {
    }

    /** @param array{limit?: int, cursor?: string, status?: string} $params */
    public function list(array $params = []): array
    {
        $res = $this->client->get('/payouts', ['query' => array_filter($params)]);
        return json_decode((string) $res->getBody(), true);
    }

    public function get(string $payoutId): array
    {
        $res = $this->client->get("/payouts/{$payoutId}");
        return json_decode((string) $res->getBody(), true);
    }

    public function create(string $accountId, float $amount, ?string $idempotencyKey = null): array
    {
        $opts = ['json' => ['account_id' => $accountId, 'amount' => $amount]];
        if ($idempotencyKey) {
            $opts['headers'] = ['Idempotency-Key' => $idempotencyKey];
        }
        $res = $this->client->post('/payouts', $opts);
        return json_decode((string) $res->getBody(), true);
    }
}
