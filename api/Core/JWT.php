<?php

namespace App\Core;

class JWT
{
    private const ALGORITHM  = 'HS512';
    private const HASH       = 'sha512';

    // -------------------------------------------------------------------------
    // Token generation
    // -------------------------------------------------------------------------

    /**
     * Generate an access token.
     * Expiry defaults to JWT_EXPIRY env var, or 1 hour.
     */
    public static function generateAccessToken(array $payload): string
    {
        $expiry = (int) ($_ENV['JWT_EXPIRY'] ?? 3600); // 1 hour default
        return self::encode($payload, $expiry, 'access');
    }

    /**
     * Generate a refresh token.
     * Expiry defaults to JWT_REFRESH_EXPIRY env var, or 7 days.
     */
    public static function generateRefreshToken(array $payload): string
    {
        $expiry = (int) ($_ENV['JWT_REFRESH_EXPIRY'] ?? 604800); // 7 days default
        return self::encode($payload, $expiry, 'refresh');
    }

    // -------------------------------------------------------------------------
    // Token verification
    // -------------------------------------------------------------------------

    /**
     * Verify and decode a token.
     * Returns the decoded payload on success.
     *
     * @throws \RuntimeException if the token is invalid, expired, or tampered with.
     */
    public static function verify(string $token, string $type = 'access'): array
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            throw new \RuntimeException('Invalid token structure');
        }

        [$headerB64, $payloadB64, $signature] = $parts;

        // Verify signature
        $expectedSignature = self::sign("{$headerB64}.{$payloadB64}");

        if (!hash_equals($expectedSignature, $signature)) {
            throw new \RuntimeException('Invalid token signature');
        }

        // Decode payload
        $payload = json_decode(self::base64UrlDecode($payloadB64), true);

        if (!$payload) {
            throw new \RuntimeException('Invalid token payload');
        }

        // Check expiry
        if (!isset($payload['exp']) || time() > $payload['exp']) {
            throw new \RuntimeException('Token has expired');
        }

        // Check token type
        if (!isset($payload['type']) || $payload['type'] !== $type) {
            throw new \RuntimeException("Invalid token type. Expected '{$type}'");
        }

        return $payload;
    }

    /**
     * Decode a token without verifying — useful for reading claims only.
     * Never trust this for authentication purposes.
     */
    public static function decode(string $token): ?array
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return null;
        }

        $payload = json_decode(self::base64UrlDecode($parts[1]), true);

        return $payload ?: null;
    }

    // -------------------------------------------------------------------------
    // Internals
    // -------------------------------------------------------------------------

    private static function encode(array $payload, int $expiry, string $type): string
    {
        $secret = $_ENV['JWT_SECRET'] ?? null;

        if (!$secret) {
            throw new \RuntimeException('JWT_SECRET is not set in .env');
        }

        $header = self::base64UrlEncode(json_encode([
            'alg' => self::ALGORITHM,
            'typ' => 'JWT',
        ]));

        $payload = array_merge($payload, [
            'type' => $type,
            'iat'  => time(),
            'exp'  => time() + $expiry,
        ]);

        $payloadEncoded = self::base64UrlEncode(json_encode($payload));
        $signature      = self::sign("{$header}.{$payloadEncoded}");

        return "{$header}.{$payloadEncoded}.{$signature}";
    }

    private static function sign(string $data): string
    {
        $secret = $_ENV['JWT_SECRET'] ?? null;

        if (!$secret) {
            throw new \RuntimeException('JWT_SECRET is not set in .env');
        }

        return self::base64UrlEncode(
            hash_hmac(self::HASH, $data, $secret, true)
        );
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', (4 - strlen($data) % 4) % 4));
    }
}