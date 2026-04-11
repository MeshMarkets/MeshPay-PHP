# Changelog

## 3.1.0

- **Added** `ChargesResource::createPooledCharge` and `EscrowsResource::createContribution`, `setPayee`, `cancelPooledEscrow` for pooled escrow API routes.

## 3.0.0

- **Removed** fiat-account methods from `WalletsResource`. Use on-ramp / off-ramp session methods instead.

## 2.0.0

Breaking — OpenAPI v1 alignment. Removed payout and API key resources. Constructor accepts optional `useXApiKeyHeader`. See MeshPay-JS CHANGELOG for API surface changes.
