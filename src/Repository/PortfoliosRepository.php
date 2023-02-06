<?php

namespace App\Repository;

use App\Entity\Portfolios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Portfolios>
 *
 * @method Portfolios|null find($id, $lockMode = null, $lockVersion = null)
 * @method Portfolios|null findOneBy(array $criteria, array $orderBy = null)
 * @method Portfolios[]    findAll()
 * @method Portfolios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortfoliosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Portfolios::class);
    }

    public function getManager()
    {
        return $this->getEntityManager();
    }

    public function save(Portfolios $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Portfolios $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function removeAllocations(Portfolios $entity, bool $flush = false): void
    {
        $items = $entity->getAllocations();
        foreach($items as $item){
            $this->getEntityManager()->remove($item);
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function removeAllOrders(Portfolios $entity, bool $flush = false): void
    {
        $items = $entity->getOrders();
        foreach($items as $item){
            $this->getEntityManager()->remove($item);
        }

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
    //     * @return Portfolios[] Returns an array of Portfolios objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Portfolios
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
