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

    public function getBetween(array $value)
    {
        return $this->createQueryBuilder('r')
            ->select('IDENTITY(r.Room_ID)')
            ->where('r.StartDate BETWEEN :begin AND :end')
            ->orWhere('r.EndDate BETWEEN :begin AND :end')
            ->setParameter('begin', $value[0])
            ->setParameter('end', $value[1])
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

}
