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

    public function listFiatAccounts(string $membershipId): array
    {
        $res = $this->client->get('/wallets/fiat-accounts', ['query' => ['membership_id' => $membershipId]]);
        return json_decode((string) $res->getBody(), true);
    }

    /** @param array<string, mixed> $body */
    public function linkFiatAccount(array $body, string $idempotencyKey): ?array
    {
        $res = $this->client->post('/wallets/fiat-accounts', [
            'json' => $body,
            'headers' => ['Idempotency-Key' => $idempotencyKey],
        ]);
        $raw = (string) $res->getBody();
        if ($raw === '') {
            return null;
        }
        return json_decode($raw, true);
    }

    public function unlinkFiatAccount(string $membershipId, string $fiatAccountId, string $idempotencyKey): void
    {
        $this->client->delete('/wallets/fiat-accounts', [
            'query' => [
                'membership_id' => $membershipId,
                'fiat_account_id' => $fiatAccountId,
            ],
            'headers' => ['Idempotency-Key' => $idempotencyKey],
        ]);
    }
}
