<?php

namespace Drupal\deepai\Generator;

use Drupal\Component\Render\FormattableMarkup;
use GuzzleHttp\Exception\GuzzleException;
use Drupal\Component\Serialization\Json;

class DeepaiClient
{
    /**
     * @var \GuzzleHttp\Client;
     */
    private $httpClient;

    /**
     * @var \Drupal\Core\Config\ImmutableConfig;
     */
    private $config;

    /**
     * DeepAIClient Constructor
     * @param $http_client_factory \Drupal\Core\Http\ClientFactory
     */
    public function __construct($http_client_factory, $configFactory)
    {
        $this->config = $configFactory->get('deepai.adminsettings');
        $this->httpClient = $http_client_factory->fromOptions([
            'base_uri' => 'https://api.deepai.org',
        ]);
    }

    /**
     * Generate text
     */
    public function generate()
    {
        $text = $this->config->get('deepai_base_text');
        $api_key = $this->config->get('deepai_api_key');
        
        try {
            $res = $this->httpClient->request('POST', '/api/text-generator', [
                'headers' => [
                    'Api-Key' => $api_key,
                ],
                'form_params' => [
                    'text' => $text,
                ]
            ]);
            return Json::decode($res->getBody());
        }
        catch (GuzzleException $error) {
            $response = $error->getResponse();
            $response_info = $response->getBody()->getContents();
            $message = new FormattableMarkup(
                'API connection Error: <pre>@response</pre>',
                ['@response' => print_r($response_info, TRUE)]
            );
            watchdog_exception('Remote API Connection', $error, $message);
            return $error;
        }
        catch (\Exception $error) {
            watchdog_exception(
                'Remote API Connection',
                $error, 
                t('Unknown Error: @error', ['@error' => $error->getMessage()])
            );
            return $error;
        }
    }
}