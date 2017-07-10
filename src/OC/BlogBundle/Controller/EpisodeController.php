<?php

namespace OC\BlogBundle\Controller;

use OC\BlogBundle\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use OC\BlogBundle\Form\EpisodeType;

/**
 * Episode controller.
 *
 */
class EpisodeController extends Controller
{
    /**
     * Lists all episode entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $episodes = $em->getRepository('OCBlogBundle:Episode')->findAll();

        return $this->render('OCBlogBundle:Episode:index.html.twig', array(
            'episodes' => $episodes,
        ));
    }

    /**
     * Creates a new episode entity.
     *
     */
    public function newAction(Request $request)
    {
        $episode = new Episode();
        $form = $this->createForm('OC\BlogBundle\Form\EpisodeType', $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($episode);
            $em->flush();

            return $this->redirectToRoute('admin_episode_show', array('id' => $episode->getId()));
        }

        return $this->render('OCBlogBundle:Episode:new.html.twig', array(
            'episode' => $episode,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a episode entity.
     *
     */
    public function showAction(Episode $episode)
    {
        $deleteForm = $this->createDeleteForm($episode);

        return $this->render('OCBlogBundle:Episode:show.html.twig', array(
            'episode' => $episode,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing episode entity.
     *
     */
    public function editAction(Request $request, Episode $episode)
    {
        $deleteForm = $this->createDeleteForm($episode);
        $editForm = $this->createForm('OC\BlogBundle\Form\EpisodeType', $episode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_episode_edit', array('id' => $episode->getId()));
        }

        return $this->render('OCBlogBundle:Episode:edit.html.twig', array(
            'episode' => $episode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a episode entity.
     *
     */
    public function deleteAction(Request $request, Episode $episode)
    {
        $form = $this->createDeleteForm($episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($episode);
            $em->flush();
        }

        return $this->redirectToRoute('admin_episode_index');
    }

    /**
     * Creates a form to delete a episode entity.
     *
     * @param Episode $episode The episode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Episode $episode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_episode_delete', array('id' => $episode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
