<?php

namespace App\Repository;

use App\Entity\Scategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Scategories>
 *
 * @method Scategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scategories[]    findAll()
 * @method Scategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scategories::class);
    }

//    /**
//     * @return Scategories[] Returns an array of Scategories objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Scategories
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
