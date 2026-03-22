<?php

namespace MeshPay;

use GuzzleHttp\Client;

class WebhookEndpointsResource
{
    public function __construct(private Client $client)
    {
    }

    /** @return array<int, array<string, mixed>> */
    public function list(): array
    {
        $res = $this->client->get('/webhook-endpoints');
        $decoded = json_decode((string) $res->getBody(), true);
        if (is_array($decoded) && array_is_list($decoded)) {
            return $decoded;
        }
        if (is_array($decoded) && isset($decoded['data']) && is_array($decoded['data'])) {
            return $decoded['data'];
        }
        return [];
    }

    public function get(string $id): array
    {
        $res = $this->client->get("/webhook-endpoints/{$id}");
        return json_decode((string) $res->getBody(), true);
    }

    /** @param array<int, string> $events */
    public function create(string $url, array $events, ?string $secret = null): array
    {
        $body = ['url' => $url, 'events' => $events];
        if ($secret !== null) {
            $body['secret'] = $secret;
        }
        $res = $this->client->post('/webhook-endpoints', ['json' => $body]);
        return json_decode((string) $res->getBody(), true);
    }

    /** @param array<int, string>|null $events */
    public function update(string $id, ?bool $active = null, ?array $events = null): array
    {
        $body = [];
        if ($active !== null) {
            $body['active'] = $active;
        }
        if ($events !== null) {
            $body['events'] = $events;
        }
        $res = $this->client->patch("/webhook-endpoints/{$id}", ['json' => $body]);
        return json_decode((string) $res->getBody(), true);
    }

    public function delete(string $id): void
    {
        $this->client->delete("/webhook-endpoints/{$id}");
    }

    /** @return array<int, array<string, mixed>> */
    public function listDeliveries(string $id, ?int $limit = null): array
    {
        $query = [];
        if ($limit !== null) {
            $query['limit'] = $limit;
        }
        $res = $this->client->get("/webhook-endpoints/{$id}/deliveries", ['query' => $query]);
        $decoded = json_decode((string) $res->getBody(), true);
        if (is_array($decoded) && array_is_list($decoded)) {
            return $decoded;
        }
        if (is_array($decoded) && isset($decoded['data']) && is_array($decoded['data'])) {
            return $decoded['data'];
        }
        return [];
    }
}
