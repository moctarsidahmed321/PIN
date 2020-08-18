<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\FormulaireAuthentificationAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_register")
     * @Route("/inscription-admin", name="app_register_admin")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, FormulaireAuthentificationAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // C'est pour crypter le mot de passe de l'utilisateur
            $motDePasseEncoder =  $passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($motDePasseEncoder);

            // Si l'utilisateur crée un compte admin il aura le role d'admin sinon le role utilisateur
            if ($request->get('_route') === 'app_register_admin') {
                $user->setRoles(['ROLE_ADMIN']);
            } else {

                $user->setRoles(['ROLE_USER']);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            // Forcer la connection et retour à la page d'accueil
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
