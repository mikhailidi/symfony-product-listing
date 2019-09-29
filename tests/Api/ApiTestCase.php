<?php

namespace App\Tests\Api;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ApiTestCase
 * @package App\Tests\Api\Controller
 */
class ApiTestCase extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;


    protected function setUp()
    {
        parent::setUp();
        $this->client = self::createClient();
    }

}