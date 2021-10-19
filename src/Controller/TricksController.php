<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Images;
use App\Entity\Tricks;
use App\Entity\Videos;
use App\Form\TricksType;
use App\Repository\TricksRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/tricks")
 */
class TricksController extends AbstractController
{
    /**
     * @Route("/", name="tricks_index", methods={"GET"})
     */
    public function index(TricksRepository $tricksRepository): Response
    {
        return $this->render('tricks/index.html.twig', [
            'tricks' => $tricksRepository->findAll(),
        ]);
    }
    /**
     * @Route("/new", name="tricks_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $user): Response
    {
        $errors = null;
        $trick = new Tricks();
        $form = $this->createForm(TricksType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // cellect the form data
            $trick = $form->getData();
            // store user id
            $trick->setUserId($user);
            // On récupère les images transmises
            $images = $form->get('images')->getData();
            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // On crée l'image dans la base de données
                $img = new Images();
                $img->setName($fichier);
                $trick->addImage($img);
            }
            // stock video embed link
            $video_embeded = $form->get('video')->getData();
            $video = new Videos();
            $video->setEmbed($video_embeded);
            $trick->addVideo($video);
            // collect group id 
            $group_id = $form->get('group')->getData();
            // find the group in the database and  add it to the form
            $entityManager = $this->getDoctrine()->getManager();
            $group = $entityManager->getRepository(Group::class)
                ->findOneBy([
                    'id' => $group_id
                ]);
            $trick->setGroupId($group);
            // collect the name to verify the uniqueness of it
            $name = $form->get('name')->getData();
            $nameExist = $entityManager->getRepository(Tricks::class)
                ->findOneBy([
                    'name' => $name
                ]);
            if (!$nameExist) {
                $entityManager->persist($trick);
                $entityManager->flush();
                return $this->redirectToRoute('tricks_index', [], Response::HTTP_SEE_OTHER);
            } else {
                $errors = "Ce nom est déja utilisé";
            }
        }
        return $this->renderForm('tricks/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
            'errors' => $errors
        ]);
    }

    /**
     * @Route("/{id}", name="tricks_show", methods={"GET"})
     */
    public function show(Tricks $trick): Response
    {
        return $this->render('tricks/show.html.twig', [
            'trick' => $trick,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tricks_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tricks $trick): Response
    {
        $form = $this->createForm(TricksType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // stock video embed link
            $video_embeded = $form->get('video')->getData();
            $video = new Videos();
            $video->setEmbed($video_embeded);
            $trick->addVideo($video);
            // On récupère les images transmises
            $images = $form->get('images')->getData();
            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // On crée l'image dans la base de données
                $img = new Images();
                $img->setName($fichier);
                $trick->addImage($img);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tricks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tricks/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="tricks_delete", methods={"POST"})
     */
    public function delete(Request $request, Tricks $trick): Response
    {
        if ($this->isCsrfTokenValid('delete' . $trick->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trick);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tricks_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/supprime/image/{id}", name="tricks_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Images $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
    /**
     * @Route("/supprime/video/{id}", name="tricks_delete_video", methods={"DELETE"})
     */
    public function deleteVideo(Videos $video, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $video->getId(), $data['_token'])) {
            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($video);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
