<?php

namespace App\Core;

interface HTTPRequest
{
    /**
     * Send an HTTP request.
     *
     * @param string $method   GET, POST, PUT, DELETE
     * @param string $url
     * @param array  $headers
     * @param mixed  $body
     *
     * @return array {
     *    "status" => int,
     *    "headers" => array,
     *    "body" => mixed
     * }
     */
    public function send(
        string $method,
        string $url,
        array $headers = [],
        $body = null
    ): array;
}
