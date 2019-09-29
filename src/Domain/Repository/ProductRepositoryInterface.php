<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    /**
     * @param Product $product
     */
    public function save(Product $product): void;
}
