<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // pobranie błędu logowania, jeśli sie taki pojawił
        $error = $authenticationUtils->getLastAuthenticationError();

        // nazwa użytkownika ostatnio wprowadzona przez aktualnego użytkownika
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'AppBundle:security/login.html.twig',
            array(
                // nazwa użytkownika ostatnio wprowadzona przez aktualnego użytkownika
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route("/loginCheck")
     */
    public function loginCheckAction()
    {
        return $this->render('AppBundle:security:login_check.html.twig', array(
            // ...
        ));
    }

}
