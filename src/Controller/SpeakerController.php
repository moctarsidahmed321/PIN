<?php

namespace App\Controller;

use App\Entity\Intervenant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SpeakerController extends AbstractController
{
    /**
     * @Route("/speaker/{id}", name="speaker")
     */
    public function index(Intervenant $intervenant)
    {
        return $this->render('speaker/index.html.twig', [
            'intervenant' => $intervenant,
        ]);
    }
}
