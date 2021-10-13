<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\TricksType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TricksController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/figures", name="tricks")
     */
    public function index(Request $request, ValidatorInterface $validator): Response
    {
        // get tricks form
        $trick = new Tricks();
        $form = $this->createForm(TricksType::class, $trick);
        // form submition & validation
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();
            // save the query with Doctrine
            $this->entityManager->persist($trick);
            // execute the query with Doctrine
            $this->entityManager->flush($trick);
        }


        return $this->render('tricks/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
