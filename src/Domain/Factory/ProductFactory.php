<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Product;
use App\Domain\Entity\ProductTag;
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
     * @param ProductTag[] $productTags Product tags
     * @return Product
     * @throws \Exception
     */
    public function createProduct(array $productData, array $productTags)
    {
        $product = new Product(
            $this->getId($productData),
            $this->getName($productData),
            $this->getDescription($productData)
        );

        $product->addTags($productTags);

        return $product;
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
        return isset($productData['description'])
            ? $productData['description']
            : '';
    }
}
