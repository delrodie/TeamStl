<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ImgMembre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Imgmembre controller.
 *
 * @Route("admin/imgmembre")
 */
class ImgMembreController extends Controller
{
    /**
     * Lists all imgMembre entities.
     *
     * @Route("/", name="admin_imgmembre_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imgMembres = $em->getRepository('AppBundle:ImgMembre')->findAll();

        return $this->render('imgmembre/index.html.twig', array(
            'imgMembres' => $imgMembres,
        ));
    }

    /**
     * Creates a new imgMembre entity.
     *
     * @Route("/new", name="admin_imgmembre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imgMembre = new Imgmembre();
        $form = $this->createForm('AppBundle\Form\ImgMembreType', $imgMembre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imgMembre);
            $em->flush($imgMembre);

            return $this->redirectToRoute('admin_imgmembre_show', array('id' => $imgMembre->getId()));
        }

        return $this->render('imgmembre/new.html.twig', array(
            'imgMembre' => $imgMembre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a imgMembre entity.
     *
     * @Route("/{id}", name="admin_imgmembre_show")
     * @Method("GET")
     */
    public function showAction(ImgMembre $imgMembre)
    {
        $deleteForm = $this->createDeleteForm($imgMembre);

        return $this->render('imgmembre/show.html.twig', array(
            'imgMembre' => $imgMembre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing imgMembre entity.
     *
     * @Route("/{id}/edit", name="admin_imgmembre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImgMembre $imgMembre)
    {
        $deleteForm = $this->createDeleteForm($imgMembre);
        $editForm = $this->createForm('AppBundle\Form\ImgMembreType', $imgMembre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_imgmembre_edit', array('id' => $imgMembre->getId()));
        }

        return $this->render('imgmembre/edit.html.twig', array(
            'imgMembre' => $imgMembre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a imgMembre entity.
     *
     * @Route("/{id}", name="admin_imgmembre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImgMembre $imgMembre)
    {
        $form = $this->createDeleteForm($imgMembre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imgMembre);
            $em->flush($imgMembre);
        }

        return $this->redirectToRoute('admin_imgmembre_index');
    }

    /**
     * Creates a form to delete a imgMembre entity.
     *
     * @param ImgMembre $imgMembre The imgMembre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImgMembre $imgMembre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_imgmembre_delete', array('id' => $imgMembre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
