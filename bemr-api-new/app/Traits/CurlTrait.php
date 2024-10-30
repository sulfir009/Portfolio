<?php

namespace App\Traits;

trait CurlTrait
{
    /**
     * @param string $url
     * @param array $options
     * @return bool|string
     */
    public function curl(string $url, array $options): bool|string
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
