<?php

namespace OC\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use OC\UserBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ReinitialisationController extends Controller {

    public function requeteAction(Request $request) {
        $reinitialisationForm = $this->createFormBuilder()->add('email', EmailType::class)->getForm();
        $reinitialisationForm->handleRequest($request);

        if ($reinitialisationForm->isSubmitted() && $reinitialisationForm->isValid()) {
            $email = $reinitialisationForm->getData()['email'];
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneByEmail($email);
            if ($user !== null) {
                $user->generateJetonReinitialisation();
                $em->flush();
                //envoyer le mail avec le lien vers réinitialisation avec le token
                $jetonReinitialisation = $user->getJetonReinitialisation();
                $message = \Swift_Message::newInstance()
                        ->setSubject('Lien de réinitialisation')
                        ->setFrom('sib64320@gmail.com')
                        ->setTo('simon-64@hotmail.com')
                        ->setBody(
                        $this->renderView(
                                'OCUserBundle:Reinitialisation:mail_reinitialisation.html.twig', array('email' => $email, 'jetonReinitialisation' => $jetonReinitialisation)), 'text/html');
                $this->get('mailer')->send($message);
            }
            $this->addFlash('info', 'Si votre adresse est exacte, un mail vous a été envoyé.');
            return $this->redirectToRoute('oc_blog_homepage');
        }
        return $this->render('OCUserBundle:Reinitialisation:requete.html.twig', array(
                    'reinitialisationForm' => $reinitialisationForm->createView()
        ));
    }

    public function reinitialisationAction(Request $request, $token) {
        //créer un formulaire qui demande l'email, le nouveau mot de passe et la confirmation du mot de passe.
        $reinitialisationForm = $this->createFormBuilder()->add('email', EmailType::class)->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Le mot de passe n\'est pas valide.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options' => array('label' => 'Mot de passe '),
                    'second_options' => array('label' => 'Répéter le mot de passe'),
                ))->getForm();
        $reinitialisationForm->handleRequest($request);

        if ($reinitialisationForm->isSubmitted() && $reinitialisationForm->isValid()) {
            $email = $reinitialisationForm->getData()['email'];
            $password = $reinitialisationForm->getData()['password'];
            $em = $this->getDoctrine()->getManager();
            
            $user = $em->getRepository(User::class)->findOneBy(['email'=>$email,'jetonReinitialisation'=>$token]);
            if($user===null){
               $this->addFlash('danger', 'Couple jeton et email invalides.');
               return $this->redirectToRoute('oc_blog_homepage');
            }
            
            if($user->getReinitialisationDatetime()<(new \DateTime())->sub(new \DateInterval('P1D'))){
                $this->addFlash('danger', ' Jeton expiré.');
               return $this->redirectToRoute('oc_blog_homepage');
            }
            
            $user->setPlainPassword($password)
                  ->setJetonReinitialisation(null)
                  ->setReinitialisationDatetime(null);
            
            $em->flush();
             
                
            $this->addFlash('success', 'Mot de passe modifié.');
            return $this->redirectToRoute('oc_blog_homepage');
        }





        return $this->render('OCUserBundle:Reinitialisation:reinitialisation.html.twig', array(
        'reinitialisationForm'=>$reinitialisationForm->createView()
                
        ));
    }

}
