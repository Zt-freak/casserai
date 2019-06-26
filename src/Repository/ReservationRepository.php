<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
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

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getRoomsByDate(\Datetime $date) {
        $startFrom = new \DateTime($date->format("Y-m-d")." 00:00:00");
        $startTo   = new \DateTime($date->format("Y-m-d")." 23:59:59");

        $endFrom = new \DateTime($date->format("Y-m-d")." 00:00:00");
        $endTo   = new \DateTime($date->format("Y-m-d")." 23:59:59");

        $qb = $this->createQueryBuilder("e");
        $qb
            ->where('e.date_start BETWEEN :startFrom AND :startTo')
            ->andWhere('e.date_end BETWEEN :endFrom AND :endTo')

            ->orWhere('e.date_start < :startFrom')
            ->andWhere('e.date_end > :endTo')

            ->orWhere('e.date_start < :startFrom')
            ->andWhere('e.date_end BETWEEN :endFrom AND :endTo')

            ->orWhere('e.date_start BETWEEN :startFrom AND :startTo')
            ->andWhere('e.date_end > :endTo')

            ->orderby('e.date_start', 'ASC')
            ->setParameter('startFrom', $startFrom )
            ->setParameter('startTo', $startTo)
            ->setParameter('endFrom', $endFrom )
            ->setParameter('endTo', $endTo)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     * $value = ['checkin' => '17-05-2019', 'checkout' => '24-05-2019']
     */
    public function findRoomsReserved($value)
    {
        dump($value);
        /*halt();*/
        return $this->createQueryBuilder('r')
            ->andWhere('r.DateStart BETWEEN :checkin AND :checkout')
            ->setParameter('checkin', $value['checkin'])
            ->setParameter('checkout', $value['checkout'])
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     * $value = ['checkin' => '17-05-2019', 'checkout' => '24-05-2019']
     */
    public function findRooms($value)
    {
        dump($value);
        /*halt();*/
        return $this->createQueryBuilder('r')
            ->andWhere('r.DateStart BETWEEN :checkin AND :checkout')
            ->setParameter('checkin', $value['checkin'])
            ->setParameter('checkout', $value['checkout'])
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Rooms[] Returns an array of Room objects
     * $value = ['checkin' => '17-05-2019', 'checkout' => '24-05-2019']
     */
    public function findRoomsFree($value)
    {
        dump($value);
        /*halt();*/
        return $this->createQueryBuilder('r')
            ->andWhere('r.DateStart BETWEEN :checkin AND :checkout')
            ->setParameter('checkin', $value['checkin'])
            ->setParameter('checkout', $value['checkout'])
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByUser($User)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT t FROM App:Reservation t '.
                'WHERE t.User = :User'
        )->setParameter('User', $User);

        return $query->getResult();
    }

    public function findAllToday($current_date)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT t FROM App:Reservation t '.
                'WHERE t.DateStart = :today
                OR t.DateEnd = :today'
        )->setParameter('today', $current_date);

        return $query->getResult();
    }

    public function findByUserToday($current_date, $User)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT t FROM App:Reservation t '.
                'WHERE t.User = :User
                AND t.DateStart = :today
                OR t.User = :User
                AND t.DateEnd = :today'
        )->setParameter('User', $User)
        ->setParameter('today', $current_date);
        return $query->getResult();
    }

}
