<?php

namespace App\Application\Service;

use App\Domain\Factory\ProductFactory;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Infrastructure\Repository\ProductDoctrineRepository;

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
     * @var ProductFactory
     */
    private $factory;

    /**
     * ProductApplicationService constructor.
     * @param ProductRepositoryInterface $repository
     * @param ProductFactory $factory
     */
    public function __construct(ProductRepositoryInterface $repository, ProductFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
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
        $product = $this->factory->createProduct($data);

        $this->repository->save($product);
    }
}
