<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Societe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Societe controller.
 *
 * @Route("admin/societe")
 */
class SocieteController extends Controller
{
    /**
     * Lists all societe entities.
     *
     * @Route("/", name="admin_societe_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $societes = $em->getRepository('AppBundle:Societe')->findAll();

        return $this->render('societe/index.html.twig', array(
            'societes' => $societes,
        ));
    }

    /**
     * Creates a new societe entity.
     *
     * @Route("/new", name="admin_societe_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $societe = new Societe();
        $form = $this->createForm('AppBundle\Form\SocieteType', $societe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($societe);
            $em->flush($societe);

            return $this->redirectToRoute('admin_societe_show', array('slug' => $societe->getSlug()));
        }

        return $this->render('societe/new.html.twig', array(
            'societe' => $societe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a societe entity.
     *
     * @Route("/{slug}", name="admin_societe_show")
     * @Method("GET")
     */
    public function showAction(Societe $societe)
    {
        $deleteForm = $this->createDeleteForm($societe);

        return $this->render('societe/show.html.twig', array(
            'societe' => $societe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing societe entity.
     *
     * @Route("/{slug}/edit", name="admin_societe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Societe $societe)
    {
        $deleteForm = $this->createDeleteForm($societe);
        $editForm = $this->createForm('AppBundle\Form\SocieteType', $societe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_societe_show', array('slug' => $societe->getSlug()));
        }

        return $this->render('societe/edit.html.twig', array(
            'societe' => $societe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a societe entity.
     *
     * @Route("/{id}", name="admin_societe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Societe $societe)
    {
        $form = $this->createDeleteForm($societe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($societe);
            $em->flush($societe);
        }

        return $this->redirectToRoute('admin_societe_index');
    }

    /**
     * Creates a form to delete a societe entity.
     *
     * @param Societe $societe The societe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Societe $societe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_societe_delete', array('id' => $societe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
