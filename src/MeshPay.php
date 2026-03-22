<?php

namespace MeshPay;

use GuzzleHttp\Client;

class MeshPay
{
    private Client $client;
    private Client $clientPublic;

    public function __construct(
        string $apiKey,
        string $baseUrl = 'https://YOUR_PROJECT_REF.supabase.co/functions/v1/api',
        bool $useXApiKeyHeader = false
    ) {
        $baseUrl = rtrim($baseUrl, '/') . '/';
        $authHeaders = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
        if ($useXApiKeyHeader) {
            $authHeaders['X-Api-Key'] = $apiKey;
        } else {
            $authHeaders['Authorization'] = 'Bearer ' . $apiKey;
        }
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'headers' => $authHeaders,
        ]);
        $this->clientPublic = new Client([
            'base_uri' => $baseUrl,
            'headers' => ['Accept' => 'application/json'],
        ]);
    }

    public function health(): HealthResource
    {
        return new HealthResource($this->clientPublic);
    }

    public function accounts(): AccountsResource
    {
        return new AccountsResource($this->client);
    }

    public function wallets(): WalletsResource
    {
        return new WalletsResource($this->client);
    }

    public function charges(): ChargesResource
    {
        return new ChargesResource($this->client);
    }

    public function escrows(): EscrowsResource
    {
        return new EscrowsResource($this->client);
    }

    public function webhookEndpoints(): WebhookEndpointsResource
    {
        return new WebhookEndpointsResource($this->client);
    }

    public function onRamp(): OnRampResource
    {
        return new OnRampResource($this->client);
    }

    public function offRamp(): OffRampResource
    {
        return new OffRampResource($this->client);
    }

    public function webhooks(): WebhooksResource
    {
        return new WebhooksResource();
    }
}
