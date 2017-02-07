<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Membre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Membre controller.
 *
 * @Route("admin/membre")
 */
class MembreController extends Controller
{
    /**
     * Lists all membre entities.
     *
     * @Route("/", name="admin_membre_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $membres = $em->getRepository('AppBundle:Membre')->findAll();

        return $this->render('membre/index.html.twig', array(
            'membres' => $membres,
        ));
    }

    /**
     * Creates a new membre entity.
     *
     * @Route("/new", name="admin_membre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $membre = new Membre();
        $form = $this->createForm('AppBundle\Form\MembreType', $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush($membre);

            return $this->redirectToRoute('admin_membre_show', array('slug' => $membre->getSlug()));
        }

        return $this->render('membre/new.html.twig', array(
            'membre' => $membre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a membre entity.
     *
     * @Route("/{slug}", name="admin_membre_show")
     * @Method("GET")
     */
    public function showAction(Membre $membre)
    {
        $deleteForm = $this->createDeleteForm($membre);

        return $this->render('membre/show.html.twig', array(
            'membre' => $membre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing membre entity.
     *
     * @Route("/{slug}/edit", name="admin_membre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Membre $membre)
    {
        $deleteForm = $this->createDeleteForm($membre);
        $editForm = $this->createForm('AppBundle\Form\MembreType', $membre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_membre_show', array('slug' => $membre->getSlug()));
        }

        return $this->render('membre/edit.html.twig', array(
            'membre' => $membre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a membre entity.
     *
     * @Route("/{id}", name="admin_membre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Membre $membre)
    {
        $form = $this->createDeleteForm($membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($membre);
            $em->flush($membre);
        }

        return $this->redirectToRoute('admin_membre_index');
    }

    /**
     * Creates a form to delete a membre entity.
     *
     * @param Membre $membre The membre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Membre $membre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_membre_delete', array('id' => $membre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
