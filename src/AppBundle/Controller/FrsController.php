<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Frs;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fr controller.
 *
 */
class FrsController extends Controller
{
    /**
     * Lists all fr entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frs = $em->getRepository('AppBundle:Frs')->findAll();

        return $this->render('frs/index.html.twig', array(
            'frs' => $frs,
        ));
    }

    /**
     * Creates a new fr entity.
     *
     */
    public function newAction(Request $request)
    {
        $fr = new Fr();
        $form = $this->createForm('AppBundle\Form\FrsType', $fr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fr);
            $em->flush();

            return $this->redirectToRoute('frs_show', array('id' => $fr->getId()));
        }

        return $this->render('frs/new.html.twig', array(
            'fr' => $fr,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a fr entity.
     *
     */
    public function showAction(Frs $fr)
    {
        $deleteForm = $this->createDeleteForm($fr);

        return $this->render('frs/show.html.twig', array(
            'fr' => $fr,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fr entity.
     *
     */
    public function editAction(Request $request, Frs $fr)
    {
        $deleteForm = $this->createDeleteForm($fr);
        $editForm = $this->createForm('AppBundle\Form\FrsType', $fr);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('frs_edit', array('id' => $fr->getId()));
        }

        return $this->render('frs/edit.html.twig', array(
            'fr' => $fr,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fr entity.
     *
     */
    public function deleteAction(Request $request, Frs $fr)
    {
        $form = $this->createDeleteForm($fr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fr);
            $em->flush();
        }

        return $this->redirectToRoute('frs_index');
    }

    /**
     * Creates a form to delete a fr entity.
     *
     * @param Frs $fr The fr entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Frs $fr)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frs_delete', array('id' => $fr->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
