<?php
namespace OC\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OC\BlogBundle\Entity\Commentaire;
use OC\BlogBundle\Entity\Episode;


class DefaultController extends Controller
{
    
    
    
    
    public function indexAction($numeroEpisode){
        
        $em=$this->getDoctrine()->getManager();
        $episodeRepository= $em->getRepository('OCBlogBundle:Episode');
        $episodes= $episodeRepository->findAll($numeroEpisode);
        
        
        $nbEpisodes=$episodeRepository->getNbEpisodes();
//        $commentaire=new Commentaire;
//        $createForm = $this->createForm('OC\BlogBundle\Form\CommentaireType', $commentaire);
//        $createForm->handleRequest($request);
//        if ($createForm->isSubmitted() && $createForm->isValid()) {
//            $commentaire->setEpisode($episode);
//            $em->persist($commentaire);
//            $em->flush();
        
           // return $this->redirectToRoute('oc_blog_homepage', array('numeroEpisode'=>$numeroEpisode));
       // }
    
        return $this->render('OCBlogBundle:Default:index.html.twig',array(
            'episodes'=> $episodes,
            'nbEpisodes'=>$nbEpisodes,
            'numeroEpisode'=>$numeroEpisode,
            ));
    }
    
    
    public function viewAction(Request $request, $numeroEpisode)
    {
        $em=$this->getDoctrine()->getManager();
        $episodeRepository= $em->getRepository('OCBlogBundle:Episode');
        $episode= $episodeRepository->findByNumeroWithCommentaires($numeroEpisode);
        
        if($episode===null){
            throw $this->createNotFoundException('L\'épisode n\'existe pas');
        }
        
        $nbEpisodes=$episodeRepository->getNbEpisodes();
        $commentaire=new Commentaire;
        $createForm = $this->createForm('OC\BlogBundle\Form\CommentaireType', $commentaire);
        $createForm->handleRequest($request);
        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $commentaire->setEpisode($episode);
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('oc_blog_episode', array('numeroEpisode'=>$numeroEpisode));
        }
    

        $commentaires = $em->getRepository('OCBlogBundle:Commentaire')
                       ->getCommentsForBlog($episode->getId());

        
        return $this->render('OCBlogBundle:Default:episode.html.twig', array(
            'episode'      => $episode,
            'nbEpisodes'=>$nbEpisodes,
            'numeroEpisode'=>$numeroEpisode,
            'commentaireRepository'  => $commentaires,
            'createForm'=>$createForm->createView()
        ));
        
        
    }    
        
    
    public function signalementCommentaireAction(Request $request, Commentaire $commentaire){
        $token=  $request->query->get('token');
        
        if ($this->isCsrfTokenValid('signalementToken', $token)){
          $commentaire->setSignalement(true); 
          $this->getDoctrine()->getManager()->flush();
          
          $this->addFlash('success', 'Commentaire signalé.');
                    
          
         return  $this->redirectToRoute('oc_blog_episode',array('numeroEpisode'=>$commentaire->getEpisode()->getId()));
        }
          $this->addFlash('danger', 'Token invalide, veuillez réessayer!');
          return $this->redirectToRoute('oc_blog_episode',array('numeroEpisode'=>$commentaire->getEpisode()->getId()));
    }
    
    
    
}
