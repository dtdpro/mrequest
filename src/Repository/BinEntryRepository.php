<?php

namespace App\Repository;

use App\Entity\BinEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BinEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method BinEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method BinEntry[]    findAll()
 * @method BinEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BinEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BinEntry::class);
    }

    // /**
    //  * @return BinEntry[] Returns an array of BinEntry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BinEntry
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
