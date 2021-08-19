<?php

namespace App\Traits;

// use App\modelo\GeneralSetting;
// use App\modelo\LogRequestResponse;
use Illuminate\Support\Facades\Http;

trait ProcessRequest
{
    /**
     * @param string $method
     * @param string $url
     * @param String $service
     * @param array $params
     * @param array $body
     * @return mixed
     */
    public function getResponse(string $method, string $url, String $service, array $params = [], array $body = [])
    {
        $response = null;
        $error = null;
        $headers = $this->getHeaders();
        $jsonBody = json_encode($body, true);
        
        try {
            $response = Http::retry(3, 100)
                                ->withHeaders($headers)
                                ->withBody($jsonBody, 'application/json')
                                ->{$method}($url, $params);
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        $successful = isset($response) ? $response->successful() : null;

        LogRequestResponse::saveLogRequestResponse($headers, $service, $method, $url, $params, $jsonBody, $successful, $response, $error);

        return $response;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'OMS-AppKey'    => GeneralSetting::getOMSAppKey(),
            'OMS-AppTok'    => GeneralSetting::getOMSAppTok(),
        ];
    }
}
