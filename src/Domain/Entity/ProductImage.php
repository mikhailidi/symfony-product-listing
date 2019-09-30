<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductImageDoctrineRepository")
 * @ORM\Table("product_images")
 */
class ProductImage
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @var Product
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Entity\Product", inversedBy="image")
     * @ORM\JoinColumn(nullable=true)
     */
    private $product;

    /**
     * @var string
     *
     * @ORM\Column(type="text", length=100)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(type="text", length=100)
     */
    private $originalFilename;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $mimeType;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $fileExtension;

    /**
     * ProductImage constructor.
     * @param Product $product
     * @param string $id
     * @param string $fileName
     * @param string $originalFileName
     * @param string $mimeType
     * @param string $fileExtension
     */
    public function __construct(Product $product, string $id, string $fileName, string $originalFileName, string $mimeType, string $fileExtension)
    {
        $this->product = $product;
        $this->id = $id;
        $this->filename = $fileName;
        $this->originalFilename = $originalFileName;
        $this->mimeType = $mimeType;
        $this->fileExtension = $fileExtension;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id->toString();
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getOriginalFilename(): string
    {
        return $this->originalFilename;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function getFileExtension(): string
    {
        return $this->fileExtension;
    }

    /**
     * @param Product $product
     * @return ProductImage
     */
    public function addProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
