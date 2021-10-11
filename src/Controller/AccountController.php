<?php

namespace App\Controller;

use App\Form\ModifyUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/compte", name="account")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        // get the current user
        $user = $this->getUser();
        // create form
        $form = $this->createForm(ModifyUserType::class, $user);
        // form submition & validation
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // collect the form data in the variable $user 
            $user = $form->getData();
            // get old password from the form
            $old_pwd = $form->get('old_password')->getData();
            if (isset($old_pwd)) {
                if ($encoder->isPasswordValid($user, $old_pwd)) {
                    // get the new password from the form
                    $new_pwd = $form->get('new_password')->getData();
                    // encode the new password and save it
                    if (isset($new_pwd)) {
                        $password = $encoder->encodePassword($user, $new_pwd);
                        $user->setPassword($password);
                    }
                }
            }
            // save the modified data in the database
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $this->render('account/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
