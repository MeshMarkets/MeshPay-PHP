<?php

namespace MeshPay;

use GuzzleHttp\Client;

class OffRampResource
{
    public function __construct(private Client $client)
    {
    }

    /** @param array<string, mixed> $body */
    public function createSession(array $body): array
    {
        $res = $this->client->post('/off-ramp/sessions', ['json' => $body]);
        return json_decode((string) $res->getBody(), true);
    }
}
