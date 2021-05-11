<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Ingredient;
use App\Entity\Reservation;
use App\Entity\Tapas;
use App\Entity\User;
use App\Form\CategorieType;
use App\Form\IngredientType;
use App\Form\ReservationType;
use App\Form\TapaType;
use App\Repository\GestionReservationRepository;
use App\Repository\ReservationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/gestion")
 */
class GestionController extends AbstractController
{
    /**
     * @Route("/",name="gestion_home")
     */
    public function index()
    {
        return $this->render('gestion/index.html.twig');
    }
    /**
     * @Route("/newCategorie/{id}",name="gestion_newCategorie")
     */
    public function newCatAdmin(Request $request, $id = null)
    {
        $urlFoto = "";
        if ($id == null) {
            $categorie = new Categorie();
        } else {
            $em = $this->getDoctrine()->getManager();
            $categorie = $em->getRepository(Categorie::class)->find($id);
            $urlFoto = $categorie->getPhoto();
            $categorie->setPhoto(null);
        }
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            // On récupère les images transmises
            $fotoFile = $form->get('photo')->getData();
            // $file stores the uploaded PDF file
            /** @var UploadedFile $file */
            //$fotoFile =  $categorie->getPhoto();
            //$fotoFile=new File($categorie->getPhoto());
            // Generate a unique name for the file before saving it
            $fotoFileName = md5(uniqid()) . '.' . $fotoFile->guessExtension();
            // Move the file to the directory where brochures are stored
            $fotoFile->move(
                $this->getParameter('foto_directory'),
                $fotoFileName
            );
            $categorie->setPhoto($fotoFileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('gestion_newCategorie', ['id' => $categorie->getId()]);
        }
        return $this->render('gestion/newCategorie.html.twig', array('form' => $form->createView(), 'urlFoto' => $urlFoto));
    }
    /**
     * @Route("/newTapa/{id}",name="gestion_new_tapa")
     */
    public function newTapaAdmin(Request $request,$id=null)
    {
      $urlFoto="";
      if($id==null){
        $tapa = new Tapas();
      }else{
        $em = $this->getDoctrine()->getManager();
        $tapa = $em->getRepository(Tapas::class)->find($id);
        $urlFoto=$tapa->getPhoto();
        $tapa->setPhoto(null);
      }
      $form = $this->createForm(TapaType::class, $tapa);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $tapa = $form->getData();
        // $file stores the uploaded PDF file
        /** @var UploadedFile $file */
        $fotoFile = $form->get('photo')->getData();
        // Generate a unique name for the file before saving it
        $fotoFileName = md5(uniqid()).'.'.$fotoFile->guessExtension();
        // Move the file to the directory where brochures are stored
        $fotoFile->move(
            $this->getParameter('tapafoto_directory'),
            $fotoFileName
        );
        $tapa->setPhoto($fotoFileName);
        $em = $this->getDoctrine()->getManager();
        $em->persist($tapa);
        $em->flush();
        return $this->redirectToRoute('home_tapas');
      }
      return $this->render('gestion/newTapa.html.twig',array(
          'form'=>$form->createView(),'urlFoto'=>$urlFoto));
    }
       /**
     * @Route("/newIngredients/{id}",name="gestion_newIngredients")
     */
    public function newIngredientAdmin(Request $request,$id=null)
    {
      if($id==null){
        $ingredient= new Ingredient();
      }else{
        $em = $this->getDoctrine()->getManager();
          $ingredient = $em->getRepository(Ingredient::class)->find($id);
      }
      $form = $this->createForm(IngredientType::class, $ingredient);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $ingredient = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($ingredient);
        $em->flush();
         return $this->redirectToRoute('gestion_newIngredients',['id'=>$ingredient->getId()]);
      }
      return $this->render('gestion/newIngredients.html.twig',array('form'=>$form->createView()));
    }
    
    /**
     * @Route("/insertAdmin",name="gestion_insert")
     */
    public function insertAdmin()
    {
      $user=new User();
      $password = $this->get('security.password_encoder')
          ->encodePassword($user, '1234');
      $user->setPassword($password);
      $user->setRoles(['ROLE_ADMIN']);
      $user->setUsername('admin');
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      return $this->render('gestion/index.html.twig');
    }
    /**
     * @Route("/reservations",name="gestion_reservations")
     */
    public function reservations()
    {
      //toutes les reservations
      $em = $this->getDoctrine()->getManager();
      $reservation = $em->getRepository(Reservation::class)->findAll();
      $ColorReservation = $em->getRepository(Reservation::class)->contenuAccepte();
      
      return $this->render('gestion/reservations.html.twig',array(
          'reservation'=>$reservation,
          'ColorReservation'=>$ColorReservation
              ));
    }
    /**
     * @Route("/acceptReservation/{id}",name="gestion_acceptReservation")
     */
    public function acceptReservation($id=null)
    {
      if($id!=null){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(Reservation::class)->find($id);
        $reservation->setAccepte(true);
        $em->persist($reservation);
        $em->flush();
      }
      return $this->redirectToRoute('gestion_reservations');
    }
    /**
     * @Route("/AnnulerReservation/{id}",name="gestion_AnnulerReservation")
     */
    public function AnnulerReservation($id=null)
    {
      if($id!=null){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(Reservation::class)->find($id);
        $em->remove($reservation);
        $em->flush();
      }
      return $this->redirectToRoute('gestion_reservations');
    }
    /**
     * @Route("/reservation/{id}",name="gestion_reservation")
     */
    public function unereservation(Request $request,$id=null)
    {
      $em = $this->getDoctrine()->getManager();
      if($id==null){
        // si le user a une reservation en cours
        $repository = $em->getRepository(Reservation::class);
        $reservation = $repository->findOneBy(
                    array('user' => $this->getUser(), 'accepte' => 0)
                  );
        if($reservation===null)
        {
            $reservation = new Reservation();
        }
      }
      else{
       // echo "<script>alert(\"une réservation a déja été passé\")</script>";
          $reservation = $em->getRepository(Reservation::class)->find($id);
      }
        $reservation->setUser($this->getUser());
      $form = $this->createForm(ReservationType::class, $reservation,['user' => $this->getUser()->getUsername()]);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          $reservation = $form->getData();
          $reservation->setUser($this->getUser());
          $reservation->setAccepte(false);
          $em->persist($reservation);
          $em->flush();
        return $this->redirectToRoute('gestion_reservation',['id'=>$reservation->getId()]);
      }
      return $this->render('gestion/reservation.twig',array('form'=>$form->createView()));
    }
    
}
