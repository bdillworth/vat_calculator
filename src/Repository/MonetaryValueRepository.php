<?php

namespace App\Repository;

use App\Entity\MonetaryValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MonetaryValue>
 *
 * @method MonetaryValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonetaryValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonetaryValue[]    findAll()
 * @method MonetaryValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonetaryValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonetaryValue::class);
    }

//    /**
//     * @return MonetaryValue[] Returns an array of MonetaryValue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MonetaryValue
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
