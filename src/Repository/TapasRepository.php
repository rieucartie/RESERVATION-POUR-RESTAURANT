<?php

namespace App\Repository;

use App\Entity\Tapas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * @method Tapas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tapas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tapas[]    findAll()
 * @method Tapas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TapasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tapas::class);
    }
    public function allTapas($currentPage = 1, $limit = 3)
      {
          $query = $this->createQueryBuilder('p')
              ->getQuery();
          $paginator = $this->paginationTapas($query, $currentPage, $limit);
          return array('paginator' => $paginator, 'query' => $query);
      }
      public function paginationTapas($dql, $page = 1, $limit = 3): Paginator
      {
          $paginator = new Paginator($dql);
          $paginator->getQuery()
              ->setFirstResult($limit * ($page - 1)) // Offset
              ->setMaxResults($limit); // Limit
          return $paginator;
      }
}
