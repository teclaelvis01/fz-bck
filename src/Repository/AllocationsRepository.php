<?php

namespace App\Repository;

use App\Entity\Allocations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Allocations>
 *
 * @method Allocations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Allocations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Allocations[]    findAll()
 * @method Allocations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AllocationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Allocations::class);
    }

    public function save(Allocations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Allocations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function exist(array $criteria): bool
    {
        $entity = $this->findOneBy($criteria);
        return $entity ? true : false;
    }

//    /**
//     * @return Allocations[] Returns an array of Allocations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Allocations
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
