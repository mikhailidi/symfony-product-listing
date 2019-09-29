<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    /**
     * Save the Product and its relationships to the database.
     *
     * @param Product $product
     * @return void
     */
    public function save(Product $product): void;
}
