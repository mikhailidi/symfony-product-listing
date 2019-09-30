<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\ProductDoctrineRepository")
 * @ORM\Table("products")
 */
class Product
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
     * @var string
     *
     * @ORM\Column(type="text", length=500)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Domain\Entity\ProductTag", mappedBy="product")
     */
    private $tags;

    /**
     * @var ProductImage
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Entity\ProductImage", mappedBy="product")
     */
    private $image;

    /**
     * Product constructor.
     * @param string $id
     * @param string $name
     * @param string $description
     */
    public function __construct(string $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->tags = new ArrayCollection();
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return Collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Associate ProductTag with the Product.
     *
     * @param ProductTag $tag Product tag to add
     * @return Product
     */
    public function addTag(ProductTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $tag->addProduct($this);
            $this->tags[] = $tag;
        }

        return $this;
    }

    /**
     * Associate multiple ProductTags with the Product.
     *
     * @param ProductTag[] $productTags Array of product tags
     * @return Product
     */
    public function addTags(array $productTags): self
    {
        foreach ($productTags as $tag) {
            $this->addTag($tag);
        }

        return $this;
    }

    /**
     * Remove ProductTag from the Product.
     *
     * @param ProductTag $tag Product tag to remove
     * @return Product
     */
    public function removeTag(ProductTag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * @param ProductImage $image
     * @return Product
     */
    public function addImage(ProductImage $image): self
    {
        if (!$this->image) {
            $this->image->addProduct($this);
            $this->image = $image;
        }

        return $this;
    }
}
