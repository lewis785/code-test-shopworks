<?php

namespace App\Repository;

use App\Entity\ShiftBreak;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShiftBreak|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShiftBreak|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShiftBreak[]    findAll()
 * @method ShiftBreak[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShiftBreakRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShiftBreak::class);
    }

    // /**
    //  * @return ShiftBreak[] Returns an array of ShiftBreak objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShiftBreak
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
