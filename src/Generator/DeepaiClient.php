<?php

namespace Drupal\deepai\Generator;

use Drupal\Component\Serialization\Json;

class DeepaiClient
{
    /**
     * @var \GuzzleHttp\Client;
     */
    private $httpClient;

    /**
     * DeepAIClient Constructor
     * @param $http_client_factory \Drupal\Core\Http\ClientFactory
     */
    public function __construct($http_client_factory)
    {
        // todo: inject the settings from config object
        $this->httpClient = $http_client_factory->fromOptions([
            'base_uri' => 'https://api.deepai.org',
            'text' => 'This is my text string. I hope it works!',
            'api-key' => 'quickstart-QUdJIGlzIGNvbWluZy4uLi4K',
        ]);
    }

    /**
     * Generate text
     * 
     * @param $text string
     * allow caller to override settings config base text if they want.
     */
    public function generate(string $text = NULL)
    {
        // $text ? $text : $config->get('text');
        $request = $this->httpClient->request('GET', '/api/textgenerator', []);
        return Json::decode($response->getBody());
    }
}