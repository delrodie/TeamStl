<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ImgInitiation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Imginitiation controller.
 *
 * @Route("admin/imginitiation")
 */
class ImgInitiationController extends Controller
{
    /**
     * Lists all imgInitiation entities.
     *
     * @Route("/", name="admin_imginitiation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imgInitiations = $em->getRepository('AppBundle:ImgInitiation')->findAll();

        return $this->render('imginitiation/index.html.twig', array(
            'imgInitiations' => $imgInitiations,
        ));
    }

    /**
     * Creates a new imgInitiation entity.
     *
     * @Route("/new", name="admin_imginitiation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imgInitiation = new Imginitiation();
        $form = $this->createForm('AppBundle\Form\ImgInitiationType', $imgInitiation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imgInitiation);
            $em->flush($imgInitiation);

            return $this->redirectToRoute('admin_imginitiation_show', array('id' => $imgInitiation->getId()));
        }

        return $this->render('imginitiation/new.html.twig', array(
            'imgInitiation' => $imgInitiation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a imgInitiation entity.
     *
     * @Route("/{id}", name="admin_imginitiation_show")
     * @Method("GET")
     */
    public function showAction(ImgInitiation $imgInitiation)
    {
        $deleteForm = $this->createDeleteForm($imgInitiation);

        return $this->render('imginitiation/show.html.twig', array(
            'imgInitiation' => $imgInitiation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing imgInitiation entity.
     *
     * @Route("/{id}/edit", name="admin_imginitiation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImgInitiation $imgInitiation)
    {
        $deleteForm = $this->createDeleteForm($imgInitiation);
        $editForm = $this->createForm('AppBundle\Form\ImgInitiationType', $imgInitiation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_imginitiation_edit', array('id' => $imgInitiation->getId()));
        }

        return $this->render('imginitiation/edit.html.twig', array(
            'imgInitiation' => $imgInitiation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a imgInitiation entity.
     *
     * @Route("/{id}", name="admin_imginitiation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImgInitiation $imgInitiation)
    {
        $form = $this->createDeleteForm($imgInitiation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imgInitiation);
            $em->flush($imgInitiation);
        }

        return $this->redirectToRoute('admin_imginitiation_index');
    }

    /**
     * Creates a form to delete a imgInitiation entity.
     *
     * @param ImgInitiation $imgInitiation The imgInitiation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImgInitiation $imgInitiation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_imginitiation_delete', array('id' => $imgInitiation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
