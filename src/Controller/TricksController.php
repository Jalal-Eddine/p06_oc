<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\TricksType;
// use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TricksController extends AbstractController
{
    private $entityManager;
    private UrlGeneratorInterface $urlGenerator;
    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }
    /**
     * @Route("/figures/ajouter", name="tricks")
     */
    public function index(Request $request): Response
    {
        $errors = null;
        // get tricks form
        $trick = new Tricks();
        $form = $this->createForm(TricksType::class, $trick);
        // form submition & validation
        // $trick2 = $tricksRepository
        //     ->findOneBy([
        //         'name' => 'mute'
        //     ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();
            $name = $form->get('name')->getData();
            $em = $this->entityManager;
            $nameExist = $em->getRepository(Tricks::class)
                ->findOneBy([
                    'name' => $name
                ]);
            if ($nameExist == null) {
                // save the query with Doctrine
                $this->entityManager->persist($trick);
                // execute the query with Doctrine
                $this->entityManager->flush($trick);
                return new RedirectResponse($this->urlGenerator->generate('account'));
            } else {
                $errors = "Ce nom est déja utilisé";
            }
        }
        return $this->render('tricks/createTrick.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
}
