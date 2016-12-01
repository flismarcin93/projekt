<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Mark_Place;
use AppBundle\Form\Mark_PlaceType;

/**
 * Mark_Place controller.
 *
 * @Route("/mark_place")
 */
class Mark_PlaceController extends Controller
{
    /**
     * Lists all Mark_Place entities.
     *
     * @Route("/", name="mark_place_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mark_Places = $em->getRepository('AppBundle:Mark_Place')->findAll();

        return $this->render('mark_place/index.html.twig', array(
            'mark_Places' => $mark_Places,
        ));
    }

    /**
     * Creates a new Mark_Place entity.
     *
     * @Route("/new{id}", name="mark_place_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Place $place)
    {
        $mark_Place = new Mark_Place();
        $user = $this->getUser();
        $mark_Place->getUser($user);
        $mark_Place->setPlace($place);
        $mark_Place->setMark(5);
        $form = $this->createForm('AppBundle\Form\Mark_PlaceType', $mark_Place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mark_Place);
            $em->flush();

            return $this->redirectToRoute('mark_place_show', array('id' => $mark_Place->getId()));
        }

        return $this->render('mark_place/new.html.twig', array(
            'mark_Place' => $mark_Place,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Mark_Place entity.
     *
     * @Route("/{id}", name="mark_place_show")
     * @Method("GET")
     */
    public function showAction(Mark_Place $mark_Place)
    {
        $deleteForm = $this->createDeleteForm($mark_Place);

        return $this->render('mark_place/show.html.twig', array(
            'mark_Place' => $mark_Place,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Mark_Place entity.
     *
     * @Route("/{id}/edit", name="mark_place_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Mark_Place $mark_Place)
    {
        $deleteForm = $this->createDeleteForm($mark_Place);
        $editForm = $this->createForm('AppBundle\Form\Mark_PlaceType', $mark_Place);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mark_Place);
            $em->flush();

            return $this->redirectToRoute('mark_place_edit', array('id' => $mark_Place->getId()));
        }

        return $this->render('mark_place/edit.html.twig', array(
            'mark_Place' => $mark_Place,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Mark_Place entity.
     *
     * @Route("/{id}", name="mark_place_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Mark_Place $mark_Place)
    {
        $form = $this->createDeleteForm($mark_Place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mark_Place);
            $em->flush();
        }

        return $this->redirectToRoute('mark_place_index');
    }

    /**
     * Creates a form to delete a Mark_Place entity.
     *
     * @param Mark_Place $mark_Place The Mark_Place entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mark_Place $mark_Place)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mark_place_delete', array('id' => $mark_Place->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
