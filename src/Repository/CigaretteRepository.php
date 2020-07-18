<?php

namespace App\Repository;

use App\Entity\Cigarette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cigarette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cigarette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cigarette[]    findAll()
 * @method Cigarette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CigaretteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cigarette::class);
    }

    // /**
    //  * @return Cigarette[] Returns an array of Cigarette objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cigarette
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
