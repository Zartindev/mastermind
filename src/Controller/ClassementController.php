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

    #[Route('/new', name: 'app_classement_new', methods: ['GET', 'POST'], options: ['expose' => true] )]
    public function new(Request $request, ClassementRepository $classementRepository): Response
    {
        $classement = new Classement();
      
        $joueur = $this->getUser();
        $classement->setFkIdJoueur($joueur);
        $classement->setNbWin($classement->getNbWin+1);
        $classementRepository->save($classement, true);

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
