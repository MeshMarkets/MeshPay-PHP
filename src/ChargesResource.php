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

    public function create(string $buyerId, string $sellerAccountId, float $amount, ?string $currency = null, ?string $idempotencyKey = null): array
    {
        $opts = ['json' => [
            'buyer_id' => $buyerId,
            'seller_account_id' => $sellerAccountId,
            'amount' => $amount,
        ]];
        if ($currency !== null) {
            $opts['json']['currency'] = $currency;
        }
        if ($idempotencyKey !== null) {
            $opts['headers'] = ['Idempotency-Key' => $idempotencyKey];
        }
        $res = $this->client->post('/charges', $opts);
        return json_decode((string) $res->getBody(), true);
    }

    public function fund(string $chargeId, string $entitySecretCiphertext, ?string $idempotencyKey = null): array
    {
        $opts = ['json' => ['entity_secret_ciphertext' => $entitySecretCiphertext]];
        if ($idempotencyKey !== null) {
            $opts['headers'] = ['Idempotency-Key' => $idempotencyKey];
        }
        $res = $this->client->post("/charges/{$chargeId}/fund", $opts);
        return json_decode((string) $res->getBody(), true);
    }

    public function refund(string $chargeId, ?float $amount = null, ?string $idempotencyKey = null): array
    {
        $opts = ['json' => $amount !== null ? ['amount' => $amount] : []];
        if ($idempotencyKey !== null) {
            $opts['headers'] = ['Idempotency-Key' => $idempotencyKey];
        }
        $res = $this->client->post("/charges/{$chargeId}/refund", $opts);
        return json_decode((string) $res->getBody(), true);
    }
}
