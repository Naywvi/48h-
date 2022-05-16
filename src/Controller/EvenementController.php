<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function index(EvenementRepository $repo, Request $request): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenement' => $repo,
        ]);

        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->get('recherche')->getData(); 
            $evenement = $repo->getEvenementByTitre($data);
        } else
        {
            $evenement = $repo->findAll();
        }

        return $this->render('evenement/index.html.twig', [
            'evenement' => $evenement,
            'formRecherche' => $form->createView()
        ]);
    }
}
