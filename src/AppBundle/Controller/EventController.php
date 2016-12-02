<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Event;
use AppBundle\Entity\MarkEvent;
use AppBundle\Form\EventType;
use AppBundle\Entity\Comment_Event;

/**
 * Event controller.
 *
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * Lists all Event entities.
     *
     * @Route("/", name="event_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->findBy([], ['date' => 'DESC']);

        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Creates a new Event entity.
     *
     * @Route("/new", name="event_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $event = new Event();

        $form = $this->createForm('AppBundle\Form\EventType', $event);
        $form->handleRequest($request);
//        $data = $form->getData();
//        $event->setDate($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $event->getPicture();
            $fileName = $this->get('app.brochure_uploader')->upload($file);

            $event->setPicture($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Event entity.
     *
     * @Route("/{id}", name="event_show")
     * @Method("GET")
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        $events = $this->getDoctrine()
            ->getRepository('AppBundle:Event')
            ->find($event);

        $comments = $events->getEventComments();

        $marks=$events->getMarks();
        $user = $this->getUser();
        $suma=0;
        $ilosc=0;
        foreach ( $marks as $item )
        {
            $suma+=$item->getMark();
            $ilosc++;
        }
        $srednia=$suma/$ilosc;

        return $this->render('event/show.html.twig', array(
            'event' => $event,
            'coments'=>$comments,
            'marks'=>$marks,
            'user'=>$user,
            'srednia'=>$srednia,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     * @Route("/{id}/edit", name="event_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('AppBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
        }

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and delete a event entity.
     *
     * @Route("/{id}/confirm", name="event_confirm")
     * @Method("GET")
     */
    public function confirmAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('event/delete.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Event entity.
     *
     * @Route("/{id}", name="event_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Creates a form to delete a Event entity.
     *
     * @param Event $event The Event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
