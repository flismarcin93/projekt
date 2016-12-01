<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Comment_Place;
use AppBundle\Entity\Place;
use AppBundle\Form\Comment_PlaceType;

/**
 * Comment_Place controller.
 *
 * @Route("/comment_place")
 */
class Comment_PlaceController extends Controller
{
    /**
     * Lists all Comment_Place entities.
     *
     * @Route("/", name="comment_place_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comment_Places = $em->getRepository('AppBundle:Comment_Place')->findAll();

        return $this->render('comment_place/index.html.twig', array(
            'comment_Places' => $comment_Places,
        ));
    }

    /**
     * Creates a new Comment_Place entity.
     *
     * @Route("/new/{id}", name="comment_place_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Place $place)
    {
        $user = $this->getUser();
        $comment_Place = new Comment_Place();
        $comment_Place->setUser($user);
        $comment_Place->setPlace($place);
        $form = $this->createForm('AppBundle\Form\Comment_PlaceType', $comment_Place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment_Place);
            $em->flush();

            return $this->redirectToRoute('comment_place_show', array('id' => $comment_Place->getId()));
        }

        return $this->render('comment_place/new.html.twig', array(
            'comment_Place' => $comment_Place,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Comment_Place entity.
     *
     * @Route("/{id}", name="comment_place_show")
     * @Method("GET")
     */
    public function showAction(Comment_Place $comment_Place)
    {
        $deleteForm = $this->createDeleteForm($comment_Place);

        return $this->render('comment_place/show.html.twig', array(
            'comment_Place' => $comment_Place,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Comment_Place entity.
     *
     * @Route("/{id}/edit", name="comment_place_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comment_Place $comment_Place)
    {
        $deleteForm = $this->createDeleteForm($comment_Place);
        $editForm = $this->createForm('AppBundle\Form\Comment_PlaceType', $comment_Place);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment_Place);
            $em->flush();

            return $this->redirectToRoute('comment_place_edit', array('id' => $comment_Place->getId()));
        }

        return $this->render('comment_place/edit.html.twig', array(
            'comment_Place' => $comment_Place,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Comment_Place entity.
     *
     * @Route("/{id}", name="comment_place_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comment_Place $comment_Place)
    {
        $form = $this->createDeleteForm($comment_Place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment_Place);
            $em->flush();
        }

        return $this->redirectToRoute('comment_place_index');
    }

    /**
     * Creates a form to delete a Comment_Place entity.
     *
     * @param Comment_Place $comment_Place The Comment_Place entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comment_Place $comment_Place)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_place_delete', array('id' => $comment_Place->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
