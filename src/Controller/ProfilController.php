<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProfilController extends AbstractController
{



    #[Route('/profil', name: 'app_profil')]
    public function index(SessionInterface $session, UserRepository $userRepository)
    {
        return $this->render('profil/index.html.twig', [
            'profil' => $userRepository,
        ]);
    }
}
