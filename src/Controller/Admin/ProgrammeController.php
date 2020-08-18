<?php

namespace App\Controller\Admin;

use App\Entity\Programme;
use App\Form\ProgrammeType;
use App\Repository\ProgrammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/programme")
 */
class ProgrammeController extends AbstractController
{
    /**
     * @Route("/", name="programme_index", methods={"GET"})
     */
    public function index(ProgrammeRepository $programmeRepository): Response
    {
        return $this->render('programme/index.html.twig', [
            'programmes' => $programmeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="programme_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $programme = new Programme();
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // La boucle en dessous est pour persister à un programme tout ses intervenants ajoutés
            foreach($programme->getIntervenants()->toArray() as $intervenant) {
                $intervenant->addProgramme($programme);
                $entityManager->persist($intervenant);
            }
            $entityManager->persist($programme);
            $entityManager->flush();

            return $this->redirectToRoute('programme_index');
        }

        return $this->render('programme/new.html.twig', [
            'programme' => $programme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="programme_show", methods={"GET"})
     */
    public function show(Programme $programme): Response
    {
        return $this->render('programme/show.html.twig', [
            'programme' => $programme,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="programme_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Programme $programme): Response
    {
        $ancienIntervenants = $programme->getIntervenants()->toArray();
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // La boucle ci-dessous permet de supprimer un ancien programme pour ensuite mettre à jour une modification
            foreach($ancienIntervenants as $intervenant) {
                $intervenant->removeProgramme($programme);
                $entityManager->persist($intervenant);
            }
            //Ici c'est pour parcourir tout les intervenants d'un programme et ensuite rajouter à chaque programme un intervenant
            foreach($programme->getIntervenants()->toArray() as $intervenant) {
                $intervenant->addProgramme($programme);
                $entityManager->persist($intervenant);
            }
            $entityManager->flush();

            return $this->redirectToRoute('programme_index');
        }

        return $this->render('programme/edit.html.twig', [
            'programme' => $programme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="programme_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Programme $programme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($programme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('programme_index');
    }
}
