<?php

namespace App\Controller;

use App\Entity\Tapas;
use App\Entity\Categorie;
use App\Entity\Ingredient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/accueil",name="home")
     */
    public function index()
    {
        $tapas= $this->getDoctrine()
        ->getRepository(Tapas::class)
        ->findByTop(2);
        return $this->render('tapas/index.html.twig',array('tapas'=>$tapas));
    } 
     /**
     * @Route("/tapa/{id}",name="home_tapa")
    */
    public function tapa($id=1)
    {
      $repository = $this->getDoctrine()->getRepository(Tapas::class);
      $tapa = $repository->find($id);
      return $this->render('tapas/tapa.html.twig',array("tapa"=>$tapa));
    }
    /**
     * @Route("/tapas/{currentPage}",name="home_tapas")
    */
    public function tapas($currentPage = 1)
    {
      $limit=3;
      $repository = $this->getDoctrine()->getRepository(Tapas::class);
      $tapas = $repository->allTapas($currentPage, $limit);
      $tapasResultat = $tapas['paginator'];
      $tapasQueryComplete =  $tapas['query'];
      $maxPages = ceil($tapas['paginator']->count() / $limit);
      return $this->render('tapas/tapas.html.twig', array(
            'tapas' => $tapasResultat,
            'maxPages'=>$maxPages,
            'thisPage' => $currentPage,
            'all_items' => $tapasQueryComplete
        ) );
    }
    /**
     * @Route("/qui-sommes-nous",name="home_equipe")
    */
    public function nosotros()
    {
      return $this->render('tapas/equipe.html.twig');
    }
    /**
     * @Route("/contact/{site}",name="home_contact")
    */
    public function contactar($lieu="tous")
    {
      return $this->render('tapas/bars.html.twig',array("lieu"=>$lieu));
    }
     /**
     * @Route("/ingredient/{currentPage}",name="home_ingredient")
    */
    public function Ingredient($currentPage = 1)
    {
      $limit=8;
      $repository = $this->getDoctrine()->getRepository(Ingredient::class);
      $ingredients = $repository->allIngrediente($currentPage, $limit);
      $ingredientsResult = $ingredients['paginator'];
      $ingredientsQueryComplete =  $ingredients['query'];
      $maxPages = ceil($ingredients['paginator']->count() / $limit);
      return $this->render('tapas/Ingredient.html.twig', array(
            'ingredients' => $ingredientsResult,
            'maxPages'=>$maxPages,
            'thisPage' => $currentPage,
            'all_items' => $ingredientsQueryComplete
        ) );
    }
    /**
     * @Route("/categories/{currentPage}",name="home_categories")
    */
    public function Cats($currentPage = 1)
    {
      $limit=3;
      $repository = $this->getDoctrine()->getRepository(Categorie::class);
      $categories = $repository->allCategories($currentPage, $limit);
      $categoriesResult = $categories['paginator'];
      $categoriesQueryComplete =  $categories['query'];
      $maxPages = ceil($categories['paginator']->count() / $limit);
      return $this->render('tapas/categories.html.twig', array(
            'categories' => $categoriesResult,
            'maxPages'=>$maxPages,
            'thisPage' => $currentPage,
            'all_items' => $categoriesQueryComplete
        ) );
    }
    /**
     * @Route("/categorie/{id}",name="home_categorie")
    */
    public function Cat($id)
    {
      $repository = $this->getDoctrine()->getRepository(Categorie::class);
      $categorie = $repository->find($id);
      return $this->render('tapas/categorie.html.twig',array("categorie"=>categorie));
    }
    
}
