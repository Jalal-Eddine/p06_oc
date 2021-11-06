<?php

namespace App\Controller;

use App\Repository\TricksRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(TricksRepository $tricksRepository): Response
    {
        $limit = 3;
        $tricksNb = $tricksRepository->count([]);
        $tricks = $tricksRepository->findBy([], ['creation_date' => 'DESC'], $limit, null);
        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'tricksNb' => $tricksNb
        ]);
    }
}
