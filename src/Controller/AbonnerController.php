<?php

namespace App\Controller;

use App\Entity\Programme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AbonnerController extends AbstractController
{
    /**
     * @Route("/abonner/{id}", name="abonner")
     */
    public function index(Programme $programme)
    {
        //// Pour récupérer l'utilisateur connecté
        $user = $this->getUser();
        $user->addProgramme($programme);
        $programme->addUser($user);
        
        //Pour envoyer à la base de données 
        $this->getDoctrine()->getManager()->flush();

        // Pour afficher une alert après inscription
        $this->addFlash(
            'success',
            'Félicitations, vous êtes inscrits !'
        );

        return $this->redirectToRoute('planning');
    }
}
