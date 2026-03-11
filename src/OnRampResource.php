<?php

namespace MeshPay;

use GuzzleHttp\Client;

class OnRampResource
{
    public function __construct(private Client $client)
    {
    }

    /** @param array{amount_usd?: float, amount_usdc?: float} $params */
    public function getQuote(array $params): array
    {
        $res = $this->client->post('/on-ramp/quote', ['json' => array_filter($params)]);
        return json_decode((string) $res->getBody(), true);
    }

    public function executeTrade(string $quoteId, ?string $idempotencyKey = null): array
    {
        $opts = ['json' => ['quote_id' => $quoteId]];
        if ($idempotencyKey !== null) {
            $opts['headers'] = ['Idempotency-Key' => $idempotencyKey];
        }
        $res = $this->client->post('/on-ramp/trade', $opts);
        return json_decode((string) $res->getBody(), true);
    }
}
