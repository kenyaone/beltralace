<?php

namespace App\Services\Recaptcha;

class GoogleRecaptchaService
{
    private static string $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

    public static function verify(string $token, ?string $remoteIp = null, float $threshold = 0.5): object
    {
        $secretKey = $_ENV['GOOGLE_RECAPTCHA_SECRET_KEY'] ?? '';

        if (empty($secretKey)) {
            throw new \RuntimeException('GOOGLE_RECAPTCHA_SECRET_KEY is not configured.');
        }

        if (empty($token)) {
            return (object) [
                'success' => false,
                'message' => 'reCAPTCHA token is missing. Please try again.'
            ];
        }

        $postFields = [
            'secret'   => $secretKey,
            'response' => $token,
        ];

        if ($remoteIp) {
            $postFields['remoteip'] = $remoteIp;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$verifyUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            return (object) [
                'success' => false,
                'message' => 'reCAPTCHA verification request failed: ' . $curlError
            ];
        }

        $data = json_decode($response);

        if ($data === null) {
            return (object) [
                'success' => false,
                'message' => 'Failed to parse reCAPTCHA response.'
            ];
        }

        if (!$data->success) {
            return (object) [
                'success' => false,
                'message' => 'reCAPTCHA verification failed.',
                'error_codes' => $data->{'error-codes'} ?? []
            ];
        }

        if (isset($data->score) && $data->score < $this->threshold) {
            return (object) [
                'success' => false,
                'message' => 'reCAPTCHA score too low.',
                'score' => $data->score
            ];
        }

        return (object) [
            'success' => true,
            'score' => $data->score ?? null,
            'action' => $data->action ?? null
        ];
    }
}