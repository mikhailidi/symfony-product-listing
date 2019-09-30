<?php

namespace App\Domain\Repository;
use App\Domain\Entity\ProductImage;

/**
 * Interface ProductImageRepositoryInterface
 * @package App\Domain\Repository
 */
interface ProductImageRepositoryInterface
{
    /**
     * @param ProductImage $image
     * @return void
     */
    public function save(ProductImage $image): void;
}
