<?php

namespace App\Controller;

use App\Entity\ConfirmerCommande;
use App\Form\ConfirmerCommandeType;
use App\Repository\ConfirmerCommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/confirmer/commande")
 */
class ConfirmerCommandeController extends AbstractController
{
    /**
     * @Route("/", name="confirmer_commande_index", methods={"GET"})
     */
    public function index(ConfirmerCommandeRepository $confirmerCommandeRepository): Response
    {
        return $this->render('confirmer_commande/index.html.twig', [
            'confirmer_commandes' => $confirmerCommandeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="confirmer_commande_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $confirmerCommande = new ConfirmerCommande();
        $form = $this->createForm(ConfirmerCommandeType::class, $confirmerCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($confirmerCommande);
            $entityManager->flush();

            return $this->redirectToRoute('confirmer_commande_index');
        }

        return $this->render('confirmer_commande/new.html.twig', [
            'confirmer_commande' => $confirmerCommande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="confirmer_commande_show", methods={"GET"})
     */
    public function show(ConfirmerCommande $confirmerCommande): Response
    {
        return $this->render('confirmer_commande/show.html.twig', [
            'confirmer_commande' => $confirmerCommande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="confirmer_commande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ConfirmerCommande $confirmerCommande): Response
    {
        $form = $this->createForm(ConfirmerCommandeType::class, $confirmerCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('confirmer_commande_index', [
                'id' => $confirmerCommande->getId(),
            ]);
        }

        return $this->render('confirmer_commande/edit.html.twig', [
            'confirmer_commande' => $confirmerCommande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="confirmer_commande_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ConfirmerCommande $confirmerCommande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$confirmerCommande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($confirmerCommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('confirmer_commande_index');
    }
}
