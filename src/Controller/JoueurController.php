<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Form\JoueurType;
use App\Repository\JoueurRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/joueur')]
class JoueurController extends AbstractController
{
    #[Route('/index', name: 'app_joueur_index', methods: ['GET'])]
    public function index(JoueurRepository $joueurRepository): Response
    { return $this->render('joueur/index.html.twig', ['joueurs' => $joueurRepository->findAll(),]);}

    #[Route('/profil', name: 'app_joueur_profilJoueur', methods: ['GET'])]
    public function profil(JoueurRepository $joueurRepository): Response
    {
       
        return $this->render('joueur/profilJoueur.html.twig', [
            'joueurs' => $joueurRepository->findBy(
                ['id' => $this->getUser()]
            ),
        ]);
    }

    #[Route('/new', name: 'app_joueur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JoueurRepository $joueurRepository): Response
    {
        $joueur = new Joueur();
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $joueurRepository->save($joueur, true);

            return $this->redirectToRoute('app_joueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joueur/new.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/{id}', name: 'app_joueur_show', methods: ['GET'])]
    public function show(Joueur $joueur): Response
    {
        return $this->render('joueur/show.html.twig', [
            'joueur' => $joueur,
        ]);
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/{id}/edit', name: 'app_joueur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Joueur $joueur, JoueurRepository $joueurRepository, SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $joueur->setPassword(
                $userPasswordHasher->hashPassword(
                    $joueur,
                    $form->get('password')->getData()
                )
            );

            $imgProfilFile=$form->get('img_Profil')->getData();
            if($imgProfilFile){
                $originalPFname=pathinfo($imgProfilFile->getClientOriginalName(),PATHINFO_FILENAME);
                $safePFname=$slugger->slug($originalPFname);
                $newPFname=$safePFname.'-'.uniqid().'.'.$imgProfilFile->guessExtension();

                try{
                    $imgProfilFile->move(
                        $this->getParameter('images_directory'),
                        $newPFname
                    );
                }catch(FileException $e){

                }
                $joueur->setImgProfil($newPFname);
            }
            
            $imgBanniereFile=$form->get('img_Banniere')->getData();
            if($imgBanniereFile){
                $originalBFname=pathinfo($imgBanniereFile->getClientOriginalName(),PATHINFO_FILENAME);
                $safeBFname=$slugger->slug($originalBFname);
                $newBFname=$safeBFname.'-'.uniqid().'.'.$imgBanniereFile->guessExtension();

                try{
                    $imgBanniereFile->move(
                        $this->getParameter('images_directory'),
                        $newBFname
                    );
                }catch(FileException $e){
                    
                }
                $joueur->setImgBanniere($newBFname);
            }
            $joueurRepository->save($joueur, true);


            return $this->redirectToRoute('app_joueur_profilJoueur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joueur/edit.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/{id}', name: 'app_joueur_delete', methods: ['POST'])]
    public function delete(Request $request, Joueur $joueur, JoueurRepository $joueurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$joueur->getId(), $request->request->get('_token'))) {
            $this->container->get('security.token_storage')->setToken(null);
            $joueurRepository->remove($joueur, true);
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
