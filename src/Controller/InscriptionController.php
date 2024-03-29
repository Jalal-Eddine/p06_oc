<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        // add user form
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        // form submition & validation
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // collect the form data in the variable $user 
            $user = $form->getData();
            // Encode passeword
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            // save the data in the database with doctrine
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $this->redirectToRoute('account');
        }
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
