<?php

namespace App\Controller;

use App\Entity\Partie;
use App\Form\PartieType;
use App\Repository\PartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/partie')]
class PartieController extends AbstractController
{
    #[Route('/', name: 'app_partie_index', methods: ['GET'])]
    public function index(PartieRepository $partieRepository): Response
    {
        return $this->render('partie/index.html.twig', [
            'parties' => $partieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_partie_new', methods: ['GET', 'POST'], options: ['expose' => true] )]
    public function new(Request $request, PartieRepository $partieRepository): Response
    {
        $partie = new Partie();

        $decodedPartie = json_decode($request->getContent());

        $joueur = $this->getUser();
        dump($joueur);
        // new \DateTime();
        $partie->setFkIdJoueur($joueur);
        $partie->setNbcoups(count(get_object_vars($decodedPartie->rounds)));
        // On prend les variables de l'objet rounds pour pouvoir les additionner et savoir le nombres de coups que la personne a fait
        $partie->setResultat($decodedPartie->won);
        $partie->setDate(new \DateTime());
        //$partie->setTemps($decodedPartie->turnTimes_ms);
        // Il faut faire en sorte qu'on puisse additionner tous les temps de tours pour avoir le tempss total en ms ou enseconde
        dd($partie);
        return $this->renderForm('partie/new.html.twig', [
            'partie' => $partie,
        ]);
    }



    

    #[Route('/{id}', name: 'app_partie_show', methods: ['GET'])]
    public function show(Partie $partie): Response
    {
        return $this->render('partie/show.html.twig', [
            'partie' => $partie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_partie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partie $partie, PartieRepository $partieRepository): Response
    {
        $form = $this->createForm(PartieType::class, $partie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partieRepository->save($partie, true);

            return $this->redirectToRoute('app_partie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partie/edit.html.twig', [
            'partie' => $partie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_partie_delete', methods: ['POST'])]
    public function delete(Request $request, Partie $partie, PartieRepository $partieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partie->getId(), $request->request->get('_token'))) {
            $partieRepository->remove($partie, true);
        }

        return $this->redirectToRoute('app_partie_index', [], Response::HTTP_SEE_OTHER);
    }
}
