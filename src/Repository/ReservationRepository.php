<?php
namespace App\Repository;
/**
 * Description of ReservationRepository
 *
 * @author kenpa
 */
use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class); 
    }
    
    public function contenuAccepte() {
        $qb = $this->createQueryBuilder('r')
                ->select('r.accepte')
                ->getQuery();
        return $qb->getArrayResult();
    }

}

 

 


