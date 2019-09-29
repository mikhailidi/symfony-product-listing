<?php

namespace App\Application\Service;

use App\Domain\Factory\ProductFactory;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\Repository\ProductTagRepositoryInterface;
use App\Infrastructure\Repository\ProductDoctrineRepository;
use App\Infrastructure\Repository\ProductTagDoctrineRepository;

/**
 * Class ProductApplicationService
 * @package App\Application\Service
 */
class ProductApplicationService
{
    /**
     * @var ProductDoctrineRepository
     */
    private $repository;

    /**
     * @var ProductTagDoctrineRepository
     */
    private $productTagRepository;

    /**
     * @var ProductFactory
     */
    private $factory;

    /**
     * ProductApplicationService constructor.
     * @param ProductRepositoryInterface $repository
     * @param ProductTagRepositoryInterface $productTagRepository
     * @param ProductFactory $factory
     */
    public function __construct(
        ProductRepositoryInterface $repository,
        ProductTagRepositoryInterface $productTagRepository,
        ProductFactory $factory
    )
    {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->productTagRepository = $productTagRepository;
    }

    /**
     * Trigger create product command.
     *
     * @param array $data Request data
     * @return void
     * @throws \Exception
     */
    public function createProduct(array $data): void
    {
        $productTags = $this->productTagRepository->findBy(['id' => $data['tags']]);

        $product = $this->factory->createProduct($data, $productTags);

        $this->repository->save($product);
    }
}
