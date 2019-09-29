<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Product;
use Ramsey\Uuid\Uuid;

/**
 * Class ProductFactory
 * @package App\Domain\Factory
 */
class ProductFactory
{
    /**
     * Create a new product Entity.
     *
     * @param array $productData Product data
     * @return Product
     * @throws \Exception
     */
    public function createProduct(array $productData)
    {
        return new Product(
            $this->getId($productData),
            $this->getName($productData),
            $this->getDescription($productData)
        );
    }

    /**
     * @param array $productData Product data
     * @return string
     * @throws \Exception
     */
    private function getId(array $productData): string
    {
        return isset($productData['id'])
            ? $productData['id']
            : Uuid::uuid4()->toString();
    }

    /**
     * @param array $productData Product data
     * @return string
     */
    private function getName(array $productData): string
    {
        return $productData['name'];
    }

    /**
     * @param array $productData Product data
     * @return string
     */
    private function getDescription(array $productData): string
    {
        return $productData['description'];
    }
}