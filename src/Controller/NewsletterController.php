<?php

namespace App\Controller;

use App\Exception\ApiException;
use App\Entity\Newsletter;
use App\Event\NewsletterRegisteredEvent;
use App\Form\NewsletterType;
use App\Mail\ApiSpamCheckerEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{
    #[Route('/inscription_newsletter', name: 'app_newsletter_subscribe')]
    public function subscribe(
        Request $request,
        EntityManagerInterface $em,
        EventDispatcherInterface $eventDispatcher,
        ApiSpamCheckerEmail $apiSpamCheckerEmail
    ): Response {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            try {
                if($apiSpamCheckerEmail->checkEmailIfSpam($newsletter->getEmail()) === True){
                    return $this->redirectToRoute('app_index');
                }    
            } catch (\InvalidArgumentException $e) {
                $this->addFlash('warning', "Le format d'email n'est pas valide");
            } catch (ApiException) {
                $this->addFlash('warning', "Il y a eu une erreur lors du traitement de votre email");
            }
 
            $em->persist($newsletter);
            $em->flush();

            $eventDispatcher->dispatch(
                new NewsletterRegisteredEvent($newsletter),
                NewsletterRegisteredEvent::NAME
            );

            $this->addFlash('success', 'Merci, votre email a bien été enregistré');
            return $this->redirectToRoute('app_index');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', "Une erreur est survenue pendant le traitement du formulaire");
        }

        return $this->render('newsletter/subscribe_form.html.twig', [
            'newsletterForm' => $form,
        ]);
    }

}
