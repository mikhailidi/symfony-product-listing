<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Product;
use App\Domain\Entity\ProductImage;
use App\Domain\Entity\ProductTag;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class ProductFactory
 * @package App\Domain\Factory
 */
class ProductImageFactory
{

    public function createProductImage(Product $productImage, File $file, ?string $originalFilename)
    {
        $productImage = new ProductImage(
            $productImage,
            $this->getId(),
            $file->getFilename(),
            $originalFilename ?? $file->getFilename(),
            $file->getMimeType() ?? 'image/png',
            $file->guessExtension() ?? 'png'
        );


        return $productImage;
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getId(): string
    {
        return Uuid::uuid4()->toString();
    }
}
