<?php

namespace App\Controller;

use App\Entity\Intervenant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ExpertController extends AbstractController
{
    /**
     * @Route("/expert", name="expert")
     */
    public function index()
    {
        $intervenants = $this->getDoctrine()->getManager()->getRepository(Intervenant::class)->findBy([], ['nickname' => 'ASC']);

        return $this->render('expert/index.html.twig', [
            'intervenants' => $intervenants,
        ]);
    }
}
