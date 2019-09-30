<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\ProductImageRepositoryInterface;
use App\Domain\Entity\ProductImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductImage[]    findAll()
 * @method ProductImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductImageDoctrineRepository extends ServiceEntityRepository implements ProductImageRepositoryInterface
{
    /**
     * ProductImageDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductImage::class);
    }

    /**
     * @param ProductImage $image
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(ProductImage $image): void
    {
        $this->getEntityManager()->persist($image);
        $this->getEntityManager()->flush();
    }
}
