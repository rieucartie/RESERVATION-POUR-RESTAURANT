<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }
    public function allCategories($currentPage = 1, $limit = 3): array
    {
      $query = $this->createQueryBuilder('c')
          ->getQuery();

      $paginator = $this->paginationCategorie($query, $currentPage, $limit);
      return array('paginator' => $paginator, 'query' => $query);
  }
  public function paginationCategorie($dql, $page = 1, $limit = 3): Paginator
  {
      $paginator = new Paginator($dql);
      $paginator->getQuery()
          ->setFirstResult($limit * ($page - 1)) // Offset
          ->setMaxResults($limit); // Limit
      return $paginator;
  }
}
