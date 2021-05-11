<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Tapas;
use App\Entity\Reservation;
use App\Entity\Categorie;
use App\Form\TapaType;
use App\Form\EditUserType;
use App\Form\ReservaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use TapasBundle\Form\CategorieType;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    function catToArray($categorie)
    {
        $categorieArray = array();
        $categorieArray['id'] = $categorie->getId();
        $categorieArray['nombre'] = $categorie->getNom();
        $categorieArray['description'] = $$categorie->getDescription();
        return $categorieArray;
    }

    function catsToArray($categories)
    {
        $categoriesArray = array();
        foreach ($categories as $categorie) {
            $categoriesArray[] = $this->catToArray($categorie);
        }
        return $categoriesArray;
    }

    /**
     * @Route("/listecategories", methods={"GET"})
     */
    public function listecategorie()
    {
        $repository = $this->getDoctrine()->getRepository(Categorie::class);
        $categories = $repository->findAll();
        $categoriesArray = array();
        foreach ($categories as $categorie) {
            $categorieArray = array();
            $categorieArray['id'] = $categorie->getId();
            $categorieArray['nombre'] = $categorie->getNom();
            $categorieArray['description'] = $categorie->getDescription();
            $categoriesArray[] = $categorieArray;
        }
        $response = new JsonResponse($categoriesArray);
        return $response;
    }

    /**
     * @Route("/insertCategorie/{nombre}/{description}", methods={"POST"})
     */

    public function insertCategorie($nombre = "", $description = "")
    {
        if (strlen($nombre) > 0) {
            $categorie = new Categorie();
            $categorie->setNom($nombre);
            $categorie->setDescription($description);
            $categorie->setPhoto("");
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            $response = new JsonResponse($this->catToArray($categorie));
            return $response;
        }
        throw new BadRequestHttpException('faux nombre', null, 400);
    }

    /**
     * @Route("/deletecategorie/{id}", methods={"DELETE"})
     */
    public function removecategorie(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('TapasBundle:categorie')
            ->find($request->get('id'));
        if (strlen($categorie) > 0) {
            $em->remove($categorie);
            $em->flush();
            return $this->redirect($this->generateUrl('home'));
        }
        throw new BadRequestHttpException('fausse categorie', null, 400);

    }

    /**
     * @Route("/categorie/{id}", methods={"PUT"})
     */
    public function updatecategorie($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('TapasBundle:categorie')
            ->find($request->get('id'));
        if (empty($categorie)) {
            return new JsonResponse(['message' => 'categorie not found'], Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $em->merge($categorie);
            $em->flush();
            return $categorie;
        } else {
            return $form;
        }
        return $this->redirect($this->generateUrl('categorie'));

    }

}