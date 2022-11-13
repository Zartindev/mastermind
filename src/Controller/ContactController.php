<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $contact= new Contact();
        if($this->getUser() && $this->getUser()->getEmail()!=null){
            $contact->setUsername($this->getUser()->getUserIdentifier())
            ->setEmail($this->getUser()->getEmail());
        };

        $form=$this->createForm(ContactType::class,$contact);
        
        $form ->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            
            $contact=$form->getData();
            //$contact=imageAction($contact);

            $manager->persist($contact);
            $manager->flush();

            
            $email = (new TemplatedEmail())
                ->from('admin@gmail.com')
                ->to($contact->getEmail())
                ->htmlTemplate('contact/email.html.twig',)
                ->context([
                    'contact'=>$contact
                ]);

            $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre formulaire de contact a bien été envoyé'
            );
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /*public function imageAction($contact){
        $contact->setImage(base64_encode(stream_get_contents($contact->getImage())));
        return $contact;
    }*/
}
