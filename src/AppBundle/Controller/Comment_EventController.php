<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Comment_Event;
use AppBundle\Form\Comment_EventType;
use AppBundle\Entity\Event;

/**
 * Comment_Event controller.
 *
 * @Route("/comment_event")
 */
class Comment_EventController extends Controller
{
    /**
     * Lists all Comment_Event entities.
     *
     * @Route("/", name="comment_event_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comment_Events = $em->getRepository('AppBundle:Comment_Event')->findAll();

        return $this->render('comment_event/index.html.twig', array(
            'comment_Events' => $comment_Events,
        ));
    }

    /**
     * Creates a new Comment_Event entity.
     *
     * @Route("/new/{id}", name="comment_event_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Event $event)
    {
        $user = $this->getUser();
        $comment_Event = new Comment_Event();
        $comment_Event->setContent("zawartość");
        $comment_Event->setUser($user);
        $comment_Event->setEvent($event);
        $form = $this->createForm('AppBundle\Form\Comment_EventType', $comment_Event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment_Event);
            $em->flush();

            return $this->redirectToRoute('comment_event_show', array('id' => $comment_Event->getId()));
        }

        return $this->render('comment_event/new.html.twig', array(
            'comment_Event' => $comment_Event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Comment_Event entity.
     *
     * @Route("/{id}", name="comment_event_show")
     * @Method("GET")
     */
    public function showAction(Comment_Event $comment_Event)
    {
        $deleteForm = $this->createDeleteForm($comment_Event);

        return $this->render('comment_event/show.html.twig', array(
            'comment_Event' => $comment_Event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Comment_Event entity.
     *
     * @Route("/{id}/edit", name="comment_event_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comment_Event $comment_Event)
    {
        $deleteForm = $this->createDeleteForm($comment_Event);
        $editForm = $this->createForm('AppBundle\Form\Comment_EventType', $comment_Event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment_Event);
            $em->flush();

            return $this->redirectToRoute('comment_event_edit', array('id' => $comment_Event->getId()));
        }

        return $this->render('comment_event/edit.html.twig', array(
            'comment_Event' => $comment_Event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Comment_Event entity.
     *
     * @Route("/{id}", name="comment_event_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comment_Event $comment_Event)
    {
        $form = $this->createDeleteForm($comment_Event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment_Event);
            $em->flush();
        }

        return $this->redirectToRoute('comment_event_index');
    }

    /**
     * Creates a form to delete a Comment_Event entity.
     *
     * @param Comment_Event $comment_Event The Comment_Event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comment_Event $comment_Event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_event_delete', array('id' => $comment_Event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
