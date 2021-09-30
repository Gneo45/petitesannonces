<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Comments;
use App\Form\AnnonceContactType;
use App\Form\CommentsType;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use App\Service\SendMailService;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annonces", name="annonces_")
 * @package App\Controller
 */
class AnnoncesController extends AbstractController
{
    
    /**
     * @Route("/details/{slug}", name="details")
     */
    public function details($slug, AnnoncesRepository $annoncesRepo, Request $request, MailerInterface $mailer)
    {
        $annonce = $annoncesRepo->findOneBy(['slug' => $slug]);

        if(!$annonce){
            throw new NotFoundHttpException('Pas d\'annonce trouvée');

        }else{

            $form = $this->createForm(AnnonceContactType::class);

            $contact = $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                //On crée le mail
                $email = (new TemplatedEmail())
                    ->from($contact->get('email')->getData())
                    ->to($annonce->getUsers()->getEmail())
                    ->subject('Contactau sujetde votre annonce "' . $annonce->getTitle() . '"')
                    ->htmlTemplate('emails/contact_annonce.html.twig')
                    ->context([
                        'annonce' => $annonce,
                        'mail' => $contact->get('email')->getData(),
                        'message' => $contact->get('message')->getData()
                    ]);
                    //on envoie le mail
                $mailer->send($email);

                //On confirme et on redirige
                $this->addFlash('message', 'Votre e-mail a bien été envoyé');
                return $this->redirectToRoute('annonces_details', ['slug' => $annonce->getSlug()]);
            }

            return $this->render('annonces/details.html.twig', [
                'annonce' => $annonce,
                'form' => $form->createView()
        ]);
        }
      
    }
}
