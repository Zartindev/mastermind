<?php

namespace App\Controller;

use App\Entity\Classement;
use App\Form\ClassementType;
use App\Repository\ClassementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/classement')]
class ClassementController extends AbstractController
{
    #[Route('/', name: 'app_classement_index', methods: ['GET'])]
    public function index(ClassementRepository $classementRepository): Response
    {
        return $this->render('classement/index.html.twig', [
            'classements' => $classementRepository->findAll(),
        ]);
    }

    #[Route('/classementTopNbWin', name: 'app_classement_topNbWin', methods: ['GET'])]
    public function topNbWin(ClassementRepository $classementRepository): Response
    {
        return $this->render('classement/topNbWin.html.twig', [
            'classements' => $classementRepository->findBy(
                array(), array('nbWin'=>'DESC')
            ),
        ]);
    }

    #[Route('/new', name: 'app_classement_new', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function new(Request $request, ClassementRepository $classementRepository): Response
    {

        $decodedPartie = json_decode($request->getContent());

        if ($decodedPartie->won == true){ // On regarde si le joueur a gagné et si il a pas gagné on fait rien

        
        $joueur = $this->getUser();
        dump($joueur);
        // On recuperer le joueur qui est co (normal)

        $classement = $classementRepository->findOneBy(['fk_idJoueur' => $joueur]);
        // On regarde si il y a deja un classement qui existe

        if (!$classement) { // Si il y en a pas on en créé un pour lui
            $classementt = new Classement();

            $classementt->setFkIdJoueur($joueur);
            $classementt->setNbWin(1);
            $classementRepository->save($classementt, true);

            dd($classement);
        }
        // Sinon on incrémente de 1 le nombre de win
            $classement->setNbWin($classement->getNbWin()+1);
            $classementRepository->save($classement, true);
    }

        return $this->renderForm('classement/new.html.twig', [
            'classement' => $classement,
        ]);
    }

    #[Route('/{id}', name: 'app_classement_show', methods: ['GET'])]
    public function show(Classement $classement): Response
    {
        return $this->render('classement/show.html.twig', [
            'classement' => $classement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Classement $classement, ClassementRepository $classementRepository): Response
    {
        $form = $this->createForm(ClassementType::class, $classement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classementRepository->save($classement, true);

            return $this->redirectToRoute('app_classement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('classement/edit.html.twig', [
            'classement' => $classement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classement_delete', methods: ['POST'])]
    public function delete(Request $request, Classement $classement, ClassementRepository $classementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classement->getId(), $request->request->get('_token'))) {
            $classementRepository->remove($classement, true);
        }

        return $this->redirectToRoute('app_classement_index', [], Response::HTTP_SEE_OTHER);
    }
}