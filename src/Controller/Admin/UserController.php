<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use League\Csv\Writer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/utilisateur")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(array $users = []): Response
    {
        if (!$users) {
            $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        } else {
            if (isset($users['vide'])) {
                $users = [];
            }
        }

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/search", name="user_search", methods={"GET"})
     */
    public function search(Request $request)
    {
        /* j'ai fait une condition pour dire que si la variable resultatrecherche est vide ça nous renvoi vers la page
        de user index, query pour une requete get et request pour post
        */
        
        $resultatSearch = $request->query->get('mot_clef');
        if (!$resultatSearch) {
            return $this->redirectToRoute('user_index');
        }

        // on fait la recherche en base de données
        $results = $this->getDoctrine()->getManager()->getRepository(User::class)->rechercheParMotClef($resultatSearch);
        if (!$results) {
            $results['vide'] = 1;
        }
        return $this->index($results);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // Pour crypter le mot de passe d'un utilisateur
            $motDePasseEncoder =  $passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($motDePasseEncoder);
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
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/export", name="user_export")
     */
    public function export(): Response
    {
        // https://csv.thephpleague.com/
        $header = ['Nom', 'Prenom', 'Email'];
        $utilisateurs = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();

        $resultat = [];
        foreach ($utilisateurs as $utilisateur) {
            $resultat[] = [
                $utilisateur->getNom(),
                $utilisateur->getPrenom(),
                $utilisateur->getEmail(),
            ];
        }

        //load the CSV document from a string
        $csv = Writer::createFromString('');

        //insert the header
        $csv->insertOne($header);

        //insert all the records
        $csv->insertAll($resultat);

        // https://symfony.com/doc/current/components/http_foundation.html#serving-files
        $response = new Response($csv->getContent());
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_INLINE,
            'utilisateurs.csv'
        );
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
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
