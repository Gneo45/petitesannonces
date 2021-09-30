<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\SearchAnnonceType;
use App\Repository\AnnoncesRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(AnnoncesRepository $annoncesRepo, Request $request)
    {
        $annonces = $annoncesRepo->findBy(['active' => true], ['created_at' => 'desc'], 5);   

        $form = $this->createForm(SearchAnnonceType::class);

        $search = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // On recherche les annonces correspondantes aux mots clés 
            $annonces = $annoncesRepo->search(
                $search->get('mots')->getData(),
                $search->get('categorie')->getData()
        );
        }
           
        return $this->render('main/index.html.twig', [
            'annonces' => $annonces,
            'form' => $form->createView()
            
        ]);
    }

      /**
     * @Route("/mentions-legales", name="mentions")
     */
    public function mentions(): Response
    {
        return $this->render('main/mentions.html.twig');
    }

      /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('vous@domaine.fr')
                ->subject('Contact depuis le site PatitesAnnonces')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'mail' => $contact->get('email')->getData(),
                    'sujet' => $contact->get('sujet')->getData(),
                    'message' => $contact->get('message')->getData(),
                    
                ]);

                $mailer->send($email);

                $this->addFlash('message', 'Votre mail a bien été envoyé');
                return $this->redirectToRoute('contact');
        }


        return $this->render('main/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
