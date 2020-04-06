<?php

namespace Ic\ProjectAbsensi;

use Exception;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 0.0.2
 * @package \IC\ProjectAbsensi
 * @license MIT
 */
final class CodePresenter
{
    /**
     * API endpoint.
     */
    private const ENDPOINT_URL = "http://202.91.9.14:6000/api/presensi_mobile/validate_ticket";

    /**
     * Ask for X_API_KEY to IC Departement.
     */
    private const X_API_KEY = "";

    /**
     * Ask for SECRET_KEY to IC Departement.
     *
     * After you have the SECRET_KEY, you need to generate
     * a bundled secret key by using the following algorithm.
     *
     * $hashedSecretKey = substr(md5(SECRET_KEY, true), 24);
     * for ($i = 16, $i2 = 0; $i2 < 8; $i2++, $i++)
     *   $hasedSecretKey[$i] = $hashedSecretKey[$i2];
     * $bundledSecretKey = $hashedSecretKey;
     *
     * This key will be used to encrypt the payload.
     */
    private const BUNDLED_SECRET_KEY = "";

    /**
     * @var string
     */
    private $nim;

    /**
     * @var string
     */
    private $code;

    /**
     * @param string $nim
     * @param string $code
     */
    public function __construct(string $nim, string $code)
    {
        $this->nim = $nim;
        $this->code = $code;
    }

    /**
     * @throws \Exception
     * @return string
     */
    public function execute(): string
    {
        $retried = false;
        start_curl:
        $ch = curl_init(self::ENDPOINT_URL);
        curl_setopt_array($ch,
            [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode(
                    ["data" => self::encryptPayload($this->nim, $this->code)]
                ),
                CURLOPT_HTTPHEADER => [
                    "X-Api-Key: {$amikomXApiKey}",
                    "Content-Type: application/json",
                ],
                CURLOPT_USERAGENT => "okhttp/3.10.0",
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_TIMEOUT => 30
            ]
        );
        $o = curl_exec($ch);
        $err = curl_error($ch);
        $ern = curl_errno($ch);
        curl_close($ch);

        if ($err && $ern) {
            if (!$retried) {
                $retried = true;
                goto start_curl;
            }
            throw new Exception("Curl Error: ({$ern}) {$err}");
        }

        return $o;
    }

    /**
     * @param string $nim
     * @param string $code
     * @return string
     */
    public static function encryptPayload(string $nim, string $code): string
    {
        return openssl_encrypt("{$code};{$nim}", "DES-EDE3", self::BUNDLED_SECRET_KEY);
    }

    /**
     * @param string $encryptedString
     * @return string
     */
    public static function decryptPayload(string $encryptedString): string
    {
        return openssl_decrypt($encryptedString, "DES-EDE3", self::BUNDLED_SECRET_KEY);
    }
}
