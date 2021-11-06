<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Images;
use App\Entity\Tricks;
use App\Entity\Videos;
use App\Entity\Comments;
use App\Form\TricksType;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Egulias\EmailValidator\Parser\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/figures")
 */
class TricksController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /** 
     * @Route("/loadmore/{loadtimes}", name="load_more", requirements={"loadtimes"="\d+"}, methods={"POST","GET"}) 
     */
    public function loadMore($loadtimes, TricksRepository $tricksRepository, CsrfTokenManagerInterface $tokenManager, Security $security): Response
    {
        if ($security->getUser()) {
            $isConnected = true;
        } else {
            $isConnected = false;
        }
        $limit = 3;
        $off = $limit * $loadtimes;
        $tricks = $tricksRepository->findBy([], ['creation_date' => 'DESC'], $limit, $off);
        foreach ($tricks as $trick) {
            $token = $tokenManager->getToken('delete' . $trick->getId());
            $listTricks = ['id' => $trick->getId(), 'name' => $trick->getName(), 'group' => $trick->getGroup()->getName(), 'author' => $trick->getUser()->getUsername(), 'image' => $trick->getImages()[0]->getName(), 'isConnected' => $isConnected, 'token' => $token];
            $tricks2[] = $listTricks;
        }
        return $this->json($tricks2, 200);
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
            $trick->setUser($user);
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
            if ($video_embeded) {
                $video = new Videos();
                $video->setEmbed($video_embeded);
                $trick->addVideo($video);
            }
            // collect group id 
            $group = $form->get('group')->getData();
            // find the group in the database and  add it to the form
            $entityManager = $this->getDoctrine()->getManager();
            $group = $entityManager->getRepository(Group::class)
                ->findOneBy([
                    'id' => $group
                ]);
            $trick->setGroup($group);
            // set creation date
            $trick->setCreationDate(new \DateTime('NOW'));
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
     * @Route("/{id}", name="tricks_show", methods={"GET","POST"})
     */
    public function show(Tricks $trick, Request $request, Security $security, CommentsRepository $commentsRepository, $id): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && !is_null($security->getUser())) {
            $comment = $form->getData();
            $comment->setUser($security->getUser());
            $comment->setTrick($trick);
            $comment->setCreatedAt(new \DateTime('NOW'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirect($request->getUri());
        }
        $limit = 3;
        $comments = $commentsRepository->findBy(['trick' => $trick], ['createdAt' => 'DESC'], $limit, null);
        $commentsNb = $trick->getComments()->count([]);
        return $this->render('tricks/show.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
            'comments' => $comments,
            'commentsNb' => $commentsNb
        ]);
    }
    /** 
     * @Route("/loadcomments/{loadtimes}", name="load_comments", requirements={"loadtimes"="\d+"}, methods={"POST","GET"})
     * 
     */
    public function loadComments($loadtimes, CommentsRepository $commentsRepository,  Request $request): Response
    {
        // $trick = $request->get('trickid');=> method get
        // with method Post
        $trick = (int) $request->query->get('trickid');
        // dd($trick);
        $limit = 3;
        $off = $limit * $loadtimes;
        $comments = $commentsRepository->findBy(['trick' => $trick], ['createdAt' => 'DESC'], $limit, $off);
        foreach ($comments as $comment) {
            $commentInfo = ['firstname' => $comment->getUser()->getFirstname(), 'lastname' => $comment->getUser()->getLastname(), 'username' => $comment->getUser()->getUsername(), 'content' => $comment->getContent(), 'createdAt' => $comment->getCreatedAt('Y-m-d H:i:s'), 'photo' => $comment->getUser()->getPhoto()];
            $commentsList[] = $commentInfo;
        }
        return $this->json($commentsList, 200);
    }

    /**
     * @Route("/modifier/{id}", name="tricks_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tricks $trick): Response
    {
        $form = $this->createForm(TricksType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // stock video embed link
            $video_embeded = $form->get('video')->getData();
            if ($video_embeded) {
                $video = new Videos();
                $video->setEmbed($video_embeded);
                $trick->addVideo($video);
            }
            // On récupère les images transmises
            $images = $form->get('images')->getData();
            if ($images) {
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
            }
            // set modification date
            $trick->setModificationDate(new \DateTime('NOW'));
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
