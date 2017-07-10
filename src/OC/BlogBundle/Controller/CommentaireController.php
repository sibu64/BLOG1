<?php

namespace OC\BlogBundle\Controller;

use OC\BlogBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commentaire controller.
 *
 */
class CommentaireController extends Controller
{
    /**
     * Lists all commentaire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commentaireRepository=$em->getRepository('OCBlogBundle:Commentaire');

        $commentairesLicites = $commentaireRepository->getCommentByStatut(Commentaire::LICITE);
        $commentairesSignales = $commentaireRepository->getCommentByStatut(Commentaire::SIGNALE);
        $commentairesModeres = $commentaireRepository->getCommentByStatut(Commentaire::MODERE);

        return $this->render('OCBlogBundle:Commentaire:index.html.twig', array(
            'commentairesLicites' => $commentairesLicites,
            'commentairesSignales' => $commentairesSignales,
            'commentairesModeres' => $commentairesModeres,
            
        ));
    }

    

   

    /**
     * Displays a form to edit an existing commentaire entity.
     *
     */
    public function editAction(Request $request, Commentaire $commentaire)
    {
        
        $editForm = $this->createForm('OC\BlogBundle\Form\CommentaireType', $commentaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_commentaire_edit', array('id' => $commentaire->getId()));
        }

        return $this->render('OCBlogBundle:Commentaire:edit.html.twig', array(
            'commentaire' => $commentaire,
            'edit_form' => $editForm->createView(),
            
        ));
    }

    

    
    
    public function liciteCommentaireAction(Request $request, Commentaire $commentaire){
        $token=  $request->query->get('token');
        
        if ($this->isCsrfTokenValid('liciteToken', $token)){
          $commentaire->setSignalement(false)
                      ->setModere(false); 
          $this->getDoctrine()->getManager()->flush();
          
          $this->addFlash('success', 'Commentaire autorisé.');
                    
          
         return  $this->redirectToRoute('admin_commentaire_index');
        }
          $this->addFlash('danger', 'Token invalide, veuillez réessayer!');
          return $this->redirectToRoute('admin_commentaire_index');
    }
    
    
    
    public function modereCommentaireAction(Request $request, Commentaire $commentaire){
        $token=  $request->query->get('token');
        
        if ($this->isCsrfTokenValid('modereToken', $token)){
          $commentaire->setSignalement(false)
                      ->setModere(true); 
          $this->getDoctrine()->getManager()->flush();
          
          $this->addFlash('success', 'Commentaire modéré.');
                    
          
         return  $this->redirectToRoute('admin_commentaire_index');
        }
          $this->addFlash('danger', 'Token invalide, veuillez réessayer!');
          return $this->redirectToRoute('admin_commentaire_index');
    }
    
    
}
