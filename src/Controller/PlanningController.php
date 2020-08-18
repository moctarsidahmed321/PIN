<?php

namespace App\Controller;

use App\Entity\Intervenant;
use App\Repository\ProgrammeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    /**
     * @Route("/planning", name="planning")
     */
    public function index(ProgrammeRepository $programmeRepository)
    {
        $programmes = $programmeRepository->findBy([], ['id' => 'DESC']);

        return $this->render('planning/index.html.twig', [
            'programmes' => $programmes
        ]);
    }
    /**
     * @Route("/sujet-intervention/{id}", name="sujet_intervention")
     */
    public function sujetIntervention(Intervenant $intervenant)
    {

        return $this->render('planning/sujet_intervention.html.twig', [
            'intervenant' => $intervenant
        ]);
    }
}
