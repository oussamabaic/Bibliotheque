<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LivreRepository;
use App\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CommentType;
use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use App\Entity\Comment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LivreLikeRepository;
use App\Entity\LivreLike;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Repository\VoteRepository;

class BibliothequeController extends AbstractController
{
    /**
     * @Route("/", name="bibliotheque")
     */
    public function index(VoteRepository $voteRepository): Response
    {
        $r = $this->getDoctrine()->getRepository(Livre::class);
        $Livres = $r->NewsLivres();
        return $this->render('bibliotheque/index.html.twig', [
            'votes' => $voteRepository->findAll(), 'Livres' => $Livres
        ]);
    }
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('max-age', 0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);
    }


    /**
     * @Route("/bibliotheque/about", name="about-us")
     */
    public function about()
    {
        return $this->render('bibliotheque/about-us.html.twig');
    }
    /**
     * @Route("/bibliotheque/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('bibliotheque/contact.html.twig');
    }
    /**
     * @Route("/bibliotheque/blog", name="blog")
     */
    public function blog()
    {
        return $this->render('bibliotheque/blog.html.twig');
    }
    /**
     * @Route("/bibliotheque/cours-detail/{id}", name="cours-detail")
     */
    public function coursDetail(Livre $liver, Request $request, ObjectManager $manager)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setCreatedAt(new \DateTime())
                ->setLivre($liver);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('cours-detail', ['id' => $liver->getId()]);
        }
        return $this->render('bibliotheque/cours-detail.html.twig', [
            'Livre' => $liver,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/bibliotheque/CategoryWeb", name="NameCategoryWeb")
     */
    public function FuncCategoryWeb()
    {
        $r = $this->getDoctrine()->getRepository(Livre::class);
        $Livres = $r->CategoryWeb();

        return $this->render('bibliotheque/CategoryWeb.html.twig', [
            'Livres' => $Livres
        ]);
    }

    /**
     * @Route("/bibliotheque/Categoryintelligenceartificielle", name="NameCategoryintelligenceartificielle")
     */
    public function FunCategoryintelligenceartificielle()
    {
        $r = $this->getDoctrine()->getRepository(Livre::class);
        $Livres = $r->Categoryintelligenceartificielle();

        return $this->render('bibliotheque/CategoryIntelligenceartificielle.html.twig', [
            'Livres' => $Livres
        ]);
    }

    /**
     * @Route("/bibliotheque/CategorySecurity", name="NameCategorySecurity")
     */
    public function FunCategorySecurity()
    {
        $r = $this->getDoctrine()->getRepository(Livre::class);
        $Livres = $r->CategorySecurity();

        return $this->render('bibliotheque/CategorySecurity.html.twig', [
            'Livres' => $Livres
        ]);
    }

    /**
     * @Route("/bibliotheque/courses", name="courses")
     */
    public function courses()
    {
        $r = $this->getDoctrine()->getRepository(Livre::class);
        $Livres = $r->NewsLivres();

        return $this->render('bibliotheque/courses.html.twig', [
            'Livres' => $Livres
        ]);
    }
    /**
     * @Route("/bibliotheque/elements", name="elements")
     */
    public function AllLivre(LivreRepository $repo, Request $request)
    {

        $Livres = $repo->findAll();

        return $this->render('bibliotheque/elements.html.twig', [
            'Livres' => $Livres
        ]);
    }
    /**
     * @Route("/bibliotheque/elements",name="elements")
     */
    public function rechercheLivre(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Livres = $em->getRepository(Livre::class)->findAll();
        if ($request->isMethod('POST')) {
            $title = $request->get('titre');
            $Livres = $em->getRepository(Livre::class)->findBy(array("titre" => $title));
        }
        return $this->render('bibliotheque/elements.html.twig', [
            'Livres' => $Livres
        ]);
    }
    /**
     * @Route("/bibliotheque/blog-detail", name="blog-detail")
     */
    public function blogdetail()
    {
        return $this->render('bibliotheque/blog-detail.html.twig');
    }

    /**
     * Undocumented function
     *
     * @Route("/bibliotheque/cours-detail/{id}/like" , name="post_like")
     *
     * @param Livre $post
     * @param ObjectManager $manager
     * @param LivreLikeRepository $likeRepo
     * @return Response
     */
    public function like(Livre $post, ObjectManager $manager, LivreLikeRepository $likeRepo): Response
    {

        $user = $this->getUser();

        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);

        if ($post->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy([
                'post' => $post,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like Bien Supprime',
                'likes' => $likeRepo->count(['post' => $post])
            ], 200);
        }

        $like = new LivreLike();
        $like->setPost($post)
            ->setUser($user);
        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like Bien Ajouter',
            'likes' => $likeRepo->count(['post' => $post])
        ], 200);
    }
}