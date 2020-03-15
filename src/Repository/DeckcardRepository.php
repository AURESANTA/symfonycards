<?php

namespace App\Repository;

use App\Entity\Deckcard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Deckcard|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deckcard|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deckcard[]    findAll()
 * @method Deckcard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeckcardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deckcard::class);
    }

    // /**
    //  * @return Deckcard[] Returns an array of Deckcard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Deckcard
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
