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
        $off = 0;
        $tricksNb = $tricksRepository->count([]);
        $tricks = $tricksRepository->findBy([], ['creation_date' => 'DESC'], $limit, $off);
        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'tricksNb' => $tricksNb
        ]);
    }
}
