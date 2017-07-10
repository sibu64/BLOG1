<?php

namespace OC\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SecurityController extends Controller {

    public function loginAction(Request $request) {
        var_dump($request->getSession()->get('login_error'));
        $request->getSession()->remove('login_error');

        return $this->render('OCUserBundle:Security:login.html.twig', [
            // ...
        ]);
    }

}
