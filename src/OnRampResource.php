<?php

namespace MeshPay;

use GuzzleHttp\Client;

class OnRampResource
{
    public function __construct(private Client $client)
    {
    }

    /** @param array<string, mixed> $body */
    public function createSession(array $body): array
    {
        $res = $this->client->post('/on-ramp/sessions', ['json' => $body]);
        return json_decode((string) $res->getBody(), true);
    }
}
