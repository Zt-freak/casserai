<?php

namespace App\Repository;

use App\Entity\Room;
use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[]    findAll()
 * @method Room[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Room::class);

    }

    // /**
    //  * @return Room[] Returns an array of Room objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneBySomeField($value): ?Room
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
    * @return Room[] Returns an array of Room objects
    */

    public function findFreeRooms($value): ?Room
    {
        // get an ExpressionBuilder instance, so that you
        $expr = $this->_em->getExpressionBuilder();

        // create a subquery in order to take all address records for a specified user id
        $sub = $this->_em->createQueryBuilder('res')
        ->select('res.Room')
        ->from('App:Reservation', 'res')
        ->andWhere('res.DateStart BETWEEN :checkin AND :checkout');

        return $this->createQueryBuilder('r')
            /*->andWhere($expr->not($expr->exists($sub->getDQL())))*/
            ->andWhere($expr->not($expr->exists($sub->getDQL())))
            ->setParameter('checkin', $value['checkin'])
            ->setParameter('checkout', $value['checkout'])
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function testBoeking($value)
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.Reservation', 'c')
            ->addSelect('c')
            ->andWhere('c.DateStart BETWEEN :checkin AND :checkout')
            ->setParameter('checkin', $value['checkin'])
            ->setParameter('checkout', $value['checkout'])
            ->getQuery()
            ->getOneOrNullResult();
    }
    
}
