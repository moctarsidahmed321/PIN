<?php

namespace App\Controller;

use App\Entity\Page;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    
    public function index(PageRepository $pageRepository): Response
    {
        // Dans la ligne de code au dessus, j'ai fait de l'autowiring
        $pages = $pageRepository->findAll();
        $presentation = [];
        $nouvelles = [];
        foreach($pages as $page){
            if ($page->getType() === Page::NOUVELLE){
                $nouvelles[] = $page;
            } else {
                $presentation[] = $page;
            }
        }

        return $this->render('accueil/index.html.twig', [
            'nouvelles' => $nouvelles,
            'presentations' => $presentation,
        ]);
    }
}
