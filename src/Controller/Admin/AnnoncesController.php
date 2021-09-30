<?php

namespace App\Controller\Admin;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @route("/admin/annonces", name="annonces_")
 * @package App\Controller\Admin
 */
class AnnoncesController extends AbstractController
{   


    
     /**
     * @Route("/", name="home")
     */
    public function index(AnnoncesRepository $annoncesRepo)
    {
        return $this->render('admin/annonces/index.html.twig', [
            'annonces' => $annoncesRepo->findAll()
        ]);
    }

    /**
     * @Route("/activer/{id}", name="activer")
     */
    public function activer(Annonces $annonce)
    {
       $annonce->setActive(($annonce->getActive())?false:true);

       $em= $this->getDoctrine()->getManager();
       $em->persist($annonce);
       $em->flush();

       

       return new Response("true");


    }
    
    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(Annonces $annonce)
    {
       
       $em= $this->getDoctrine()->getManager();
       $em->remove($annonce);
       $em->flush();

       $this->addFlash('message', 'Annonce supprimée avec succés');
       return $this->redirectToRoute('annonces_home');

    }

  


}
