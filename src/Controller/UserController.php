<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\PostLike;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $file = $form->get('image')->getData();
            dump($request);
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

             // Move the file to the directory where brochures are stored
             try {
                $file->move(
                    $this->getParameter('imageUser_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                $form = $this->createForm(UserType::class,$user);
            
            }
            
               // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $user->setImage($fileName);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
     /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        
        $oldFileName = $user->getImage();
        $oldFileNamePath = $this->getParameter('imageUser_directory'). '/' .$user->getImage();
        $pictureFile = new File($oldFileNamePath);

        $user->setImage($pictureFile);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            if($user->getImage() != null){
                $newLogoFile =  $form->get('image')->getData();
                $fileName = $this->generateUniqueFileName().'.'.$newLogoFile->guessExtension();
                //$fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                //$file = $form->get('image')->getData();
                $newLogoFile->move(
                    $this->getParameter('imageUser_directory'),
                    $fileName
                );
            }else{
                $user->setImage($oldFileName);
            }

            $user->setImage($fileName);
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
