<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement",name="app_evenement")
     */
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

      /**
     * @Route("/evenement/new", name="evenement_create")
     * @Route("/evenement/edit/{id}", name="evenement_edit",  requirements={"id":"\d+"})
     */
    public function form(Request $request, EntityManagerInterface $manager, evenement $evenement = null)
    {
        if (!$evenement) {
            $evenement = new Evenement;
        }

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        dump($evenement);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($evenement);    
            $manager->flush();  
            return $this->redirectToRoute('evenement_show', [
                'id' => $evenement->getId()
            ]);
        }

        return $this->render("evenement/form.html.twig", [
            'editMode' => $evenement->getId() !== null,
            'formEvenement' => $form->createView()   
        ]);
    }

      /**
     * @Route("/evenement/show/{id}", name="evenement_show")
     */
    public function show (Evenement $evenement)
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
}
