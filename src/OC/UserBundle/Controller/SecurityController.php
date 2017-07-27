<?php

namespace OC\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OC\UserBundle\Entity\User;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class SecurityController extends Controller{

    public function loginAction(Request $request) {
   
        
        
       
    

    

    
    
        return $this->render('OCUserBundle:Security:login.html.twig',array(
                
            ) 
        );
    }
   
}
