<?php

namespace Drupal\deepai\Controller;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

use Drupal\deepai\Generator\DeepAIClient;

class DeepaiController extends ControllerBase
{
    private $deepaiClient;

    public function __construct(DeepAIClient $DeepAIClient)
    {
        $this->deepaiClient = $DeepAIClient;
    }

    public function generate()
    {
        $client = \Drupal::service('http_client_factory')->fromOptions([
            'text' => 'This is my text string. I hope it works!',
            'api-key' => 'quickstart-QUdJIGlzIGNvbWluZy4uLi4K',
            'base_uri' => 'https://api.deepai.org/',
        ]);

        $response = $client->get('/api/textgenerator', []);
        $text = Json::decode($response->getBody());
        return new Response($text);
    }

    public static function create(ContainerInterface $container)
    {
        $DeepaiClient = $container->get('deepai.deepai_client');
        return new static($DeepaiClient);
    }
}