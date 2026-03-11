<?php

namespace MeshPay;

use GuzzleHttp\Client;

class OffRampResource
{
    public function __construct(private Client $client)
    {
    }

    /** @param array{amount_usdc?: float, amount_usd?: float} $params */
    public function getQuote(array $params): array
    {
        $res = $this->client->post('/off-ramp/quote', ['json' => array_filter($params)]);
        return json_decode((string) $res->getBody(), true);
    }

    public function executeTrade(string $quoteId, ?string $idempotencyKey = null): array
    {
        $opts = ['json' => ['quote_id' => $quoteId]];
        if ($idempotencyKey !== null) {
            $opts['headers'] = ['Idempotency-Key' => $idempotencyKey];
        }
        $res = $this->client->post('/off-ramp/trade', $opts);
        return json_decode((string) $res->getBody(), true);
    }
}
