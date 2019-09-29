<?php

namespace App\Repository;

use App\Domain\Entity\ProductTag;
use App\Domain\Repository\ProductTagRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductTag[]    findAll()
 * @method ProductTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductTagDoctrineRepository extends ServiceEntityRepository implements ProductTagRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductTag::class);
    }
}
