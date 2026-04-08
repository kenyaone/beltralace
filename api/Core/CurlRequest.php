<?php

namespace App\Core;

class CurlRequest implements HTTPRequest
{
    private LoggerInterface $logger;

    /**
     * Default constructor uses DatabaseLogger automatically
     */
    public function __construct(?LoggerInterface $logger = null)
    {
        $this->logger = $logger ?? new DatabaseLogger(Database::getInstance());
    }

    /**
     * Optional fluent creator
     */
    public static function make(): self
    {
        return new self();
    }

    public function send(string $method, string $url, array $headers = [], $body = null): array
    {
        $startTime = microtime(true);

        $ch = curl_init();

        $formattedHeaders = [];
        foreach ($headers as $key => $value) {
            $formattedHeaders[] = "$key: $value";
        }

        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER     => $formattedHeaders,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HEADER         => true,
        ]);

        if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH'], true)) {
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                is_array($body) ? json_encode($body) : $body
            );
        }

        $rawResponse = curl_exec($ch);
        $statusCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize  = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $curlError   = curl_error($ch);

        if ($rawResponse === false) {
            $this->logger->error('HTTP Request Failed', [
                'method' => strtoupper($method),
                'url' => $url,
                'error' => $curlError,
            ]);

            return [
                'status' => 0,
                'headers' => [],
                'body' => $curlError,
            ];
        }

        $rawHeaders    = substr($rawResponse, 0, $headerSize);
        $responseBody  = substr($rawResponse, $headerSize);
        $responseHeaders = $this->parseHeaders($rawHeaders);

        $durationMs = round((microtime(true) - $startTime) * 1000, 2);

        // 🔐 redact sensitive headers
        $safeHeaders = $this->redactHeaders($headers);

        // 🧾 unified logging
        $this->logger->info('HTTP Transaction', [
            'method' => strtoupper($method),
            'url' => $url,
            'request_headers' => $safeHeaders,
            'request_body' => $body,
            'response_status' => $statusCode,
            'response_headers' => $responseHeaders,
            'response_body' => $responseBody,
            'duration_ms' => $durationMs,
        ]);

        if ($curlError) {
            $this->logger->error('HTTP Error', [
                'method' => strtoupper($method),
                'url' => $url,
                'error' => $curlError,
            ]);
        }

        return [
            'status' => $statusCode,
            'headers' => $responseHeaders,
            'body' => $responseBody,
        ];
    }

    private function parseHeaders(string $rawHeaders): array
    {
        $headers = [];
        $lines = explode("\r\n", trim($rawHeaders));
        array_shift($lines);

        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                [$key, $value] = explode(':', $line, 2);
                $headers[trim($key)] = trim($value);
            }
        }

        return $headers;
    }

    private function redactHeaders(array $headers): array
    {
        $sensitive = ['authorization', 'x-api-key'];

        foreach ($headers as $key => $value) {
            if (in_array(strtolower($key), $sensitive, true)) {
                $headers[$key] = '[REDACTED]';
            }
        }

        return $headers;
    }
}
