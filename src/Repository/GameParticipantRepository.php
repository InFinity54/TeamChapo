<?php

namespace App\Repository;

use App\Entity\GameParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameParticipant[]    findAll()
 * @method GameParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameParticipant::class);
    }

    // /**
    //  * @return GameParticipant[] Returns an array of GameParticipant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameParticipant
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
