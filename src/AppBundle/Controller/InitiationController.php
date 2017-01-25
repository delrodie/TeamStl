<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Initiation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Initiation controller.
 *
 * @Route("admin/initiation")
 */
class InitiationController extends Controller
{
    /**
     * Lists all initiation entities.
     *
     * @Route("/", name="admin_initiation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $initiations = $em->getRepository('AppBundle:Initiation')->findAll();

        return $this->render('initiation/index.html.twig', array(
            'initiations' => $initiations,
        ));
    }

    /**
     * Creates a new initiation entity.
     *
     * @Route("/new", name="admin_initiation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $initiation = new Initiation();
        $form = $this->createForm('AppBundle\Form\InitiationType', $initiation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($initiation);
            $em->flush($initiation);

            return $this->redirectToRoute('admin_initiation_show', array('slug' => $initiation->getSlug()));
        }

        return $this->render('initiation/new.html.twig', array(
            'initiation' => $initiation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a initiation entity.
     *
     * @Route("/{slug}", name="admin_initiation_show")
     * @Method("GET")
     */
    public function showAction(Initiation $initiation)
    {
        $deleteForm = $this->createDeleteForm($initiation);

        return $this->render('initiation/show.html.twig', array(
            'initiation' => $initiation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing initiation entity.
     *
     * @Route("/{slug}/edit", name="admin_initiation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Initiation $initiation)
    {
        $deleteForm = $this->createDeleteForm($initiation);
        $editForm = $this->createForm('AppBundle\Form\InitiationType', $initiation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_initiation_show', array('slug' => $initiation->getSlug()));
        }

        return $this->render('initiation/edit.html.twig', array(
            'initiation' => $initiation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a initiation entity.
     *
     * @Route("/{id}", name="admin_initiation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Initiation $initiation)
    {
        $form = $this->createDeleteForm($initiation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($initiation);
            $em->flush($initiation);
        }

        return $this->redirectToRoute('admin_initiation_index');
    }

    /**
     * Creates a form to delete a initiation entity.
     *
     * @param Initiation $initiation The initiation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Initiation $initiation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_initiation_delete', array('id' => $initiation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
