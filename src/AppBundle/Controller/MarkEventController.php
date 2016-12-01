<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\MarkEvent;
use AppBundle\Form\MarkEventType;
use AppBundle\Entity\Event;

/**
 * MarkEvent controller.
 *
 * @Route("/markevent")
 */
class MarkEventController extends Controller
{
    /**
     * Lists all MarkEvent entities.
     *
     * @Route("/", name="markevent_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $markEvents = $em->getRepository('AppBundle:MarkEvent')->findAll();

        return $this->render('markevent/index.html.twig', array(
            'markEvents' => $markEvents,
        ));
    }

    /**
     * Creates a new MarkEvent entity.
     *
     * @Route("/new/{id}", name="markevent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Event $event)
    {
        $user = $this->getUser();
        $markEvent = new MarkEvent();
        $markEvent->setUser($user);
        $markEvent->setEvent($event);
        $markEvent->setMark(5);
        $form = $this->createForm('AppBundle\Form\MarkEventType', $markEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($markEvent);
            $em->flush();

            return $this->redirectToRoute('markevent_show', array('id' => $markEvent->getId()));
        }

        return $this->render('markevent/new.html.twig', array(
            'markEvent' => $markEvent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MarkEvent entity.
     *
     * @Route("/{id}", name="markevent_show")
     * @Method("GET")
     */
    public function showAction(MarkEvent $markEvent)
    {
        $deleteForm = $this->createDeleteForm($markEvent);

        return $this->render('markevent/show.html.twig', array(
            'markEvent' => $markEvent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MarkEvent entity.
     *
     * @Route("/{id}/edit", name="markevent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MarkEvent $markEvent)
    {
        $deleteForm = $this->createDeleteForm($markEvent);
        $editForm = $this->createForm('AppBundle\Form\MarkEventType', $markEvent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($markEvent);
            $em->flush();

            return $this->redirectToRoute('markevent_edit', array('id' => $markEvent->getId()));
        }

        return $this->render('markevent/edit.html.twig', array(
            'markEvent' => $markEvent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a MarkEvent entity.
     *
     * @Route("/{id}", name="markevent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MarkEvent $markEvent)
    {
        $form = $this->createDeleteForm($markEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($markEvent);
            $em->flush();
        }

        return $this->redirectToRoute('markevent_index');
    }

    /**
     * Creates a form to delete a MarkEvent entity.
     *
     * @param MarkEvent $markEvent The MarkEvent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MarkEvent $markEvent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('markevent_delete', array('id' => $markEvent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
