<?php

namespace App\Controller;

use App\Entity\DommanderEvent;
use App\Form\DommanderEventType;
use App\Repository\DommanderEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dommander/event")
 */
class DommanderEventController extends AbstractController
{
    /**
     * @Route("/", name="dommander_event_index", methods={"GET"})
     */
    public function index(DommanderEventRepository $dommanderEventRepository): Response
    {
        return $this->render('dommander_event/index.html.twig', [
            'dommander_events' => $dommanderEventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dommander_event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dommanderEvent = new DommanderEvent();
        $form = $this->createForm(DommanderEventType::class, $dommanderEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dommanderEvent);
            $entityManager->flush();

            return $this->redirectToRoute('dommander_event_index');
        }

        return $this->render('dommander_event/new.html.twig', [
            'dommander_event' => $dommanderEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dommander_event_show", methods={"GET"})
     */
    public function show(DommanderEvent $dommanderEvent): Response
    {
        return $this->render('dommander_event/show.html.twig', [
            'dommander_event' => $dommanderEvent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dommander_event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DommanderEvent $dommanderEvent): Response
    {
        $form = $this->createForm(DommanderEventType::class, $dommanderEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dommander_event_index', [
                'id' => $dommanderEvent->getId(),
            ]);
        }

        return $this->render('dommander_event/edit.html.twig', [
            'dommander_event' => $dommanderEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dommander_event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DommanderEvent $dommanderEvent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dommanderEvent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dommanderEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dommander_event_index');
    }
}
