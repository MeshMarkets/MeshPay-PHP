<?php

namespace MeshPay;

use GuzzleHttp\Client;

class MeshPay
{
    private Client $client;

    public function __construct(string $apiKey, string $baseUrl = 'http://localhost:3000')
    {
        $this->client = new Client([
            'base_uri' => rtrim($baseUrl, '/') . '/',
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function health(): HealthResource
    {
        return new HealthResource($this->client);
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

    public function payouts(): PayoutsResource
    {
        return new PayoutsResource($this->client);
    }

    public function apiKeys(): ApiKeysResource
    {
        return new ApiKeysResource($this->client);
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
