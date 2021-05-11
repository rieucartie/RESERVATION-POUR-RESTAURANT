<?php

namespace App\Repository;

use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findAll()
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

      public function allIngrediente($currentPage = 1, $limit = 3)
  {
      $query = $this->createQueryBuilder('p')
          ->getQuery();
      $paginator = $this->paginationIngredient($query, $currentPage, $limit);
      return array('paginator' => $paginator, 'query' => $query);
  }
  public function paginationIngredient($dql, $page = 1, $limit = 3): Paginator
  {
      $paginator = new Paginator($dql);
      $paginator->getQuery()
          ->setFirstResult($limit * ($page - 1)) // Offset
          ->setMaxResults($limit); // Limit
      return $paginator;
  }
}
