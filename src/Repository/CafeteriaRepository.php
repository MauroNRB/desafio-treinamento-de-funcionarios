<?php

namespace App\Repository;

use App\Entity\Cafeteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cafeteria>
 *
 * @method Cafeteria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cafeteria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cafeteria[]    findAll()
 * @method Cafeteria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CafeteriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cafeteria::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Cafeteria $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Cafeteria $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Cafeteria[] Returns an array of Cafeteria objects
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
    public function findOneBySomeField($value): ?Cafeteria
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
