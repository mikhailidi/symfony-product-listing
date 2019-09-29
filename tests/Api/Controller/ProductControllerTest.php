<?php

namespace App\Tests\Api\Controller;

use App\Domain\Entity\Product;
use App\Tests\Api\ApiTestCase;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductControllerTest
 * @package App\Tests\Api\Controller
 */
class ProductControllerTest extends ApiTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;


    protected function setUp()
    {
        parent::setUp();

        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    /**
     * @test
     */
    public function test_create_product_successful()
    {
        // TODO: trigger image and tags

        $productData = [
            'name' => 'First product',
            'description' => 'Product description',
        ];

        $this->client->request('POST', '/api/products', $productData);

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());


        /**
         * Assert data was successfully insert to the database
         */
        $product = $this->entityManager
            ->getRepository(Product::class)
            ->find('created-id-here');

        $expectedProductData = [
            'name' => $product->getName(),
            'description' => $product->getDescription(),
        ];
        $this->assertEquals($productData, $expectedProductData);
    }
}
