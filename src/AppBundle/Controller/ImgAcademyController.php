<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ImgAcademy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Imgacademy controller.
 *
 * @Route("admin/imgacademy")
 */
class ImgAcademyController extends Controller
{
    /**
     * Lists all imgAcademy entities.
     *
     * @Route("/", name="admin_imgacademy_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imgAcademies = $em->getRepository('AppBundle:ImgAcademy')->findAll();

        return $this->render('imgacademy/index.html.twig', array(
            'imgAcademies' => $imgAcademies,
        ));
    }

    /**
     * Creates a new imgAcademy entity.
     *
     * @Route("/new", name="admin_imgacademy_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imgAcademy = new Imgacademy();
        $form = $this->createForm('AppBundle\Form\ImgAcademyType', $imgAcademy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imgAcademy);
            $em->flush($imgAcademy);

            return $this->redirectToRoute('admin_imgacademy_show', array('id' => $imgAcademy->getId()));
        }

        return $this->render('imgacademy/new.html.twig', array(
            'imgAcademy' => $imgAcademy,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a imgAcademy entity.
     *
     * @Route("/{id}", name="admin_imgacademy_show")
     * @Method("GET")
     */
    public function showAction(ImgAcademy $imgAcademy)
    {
        $deleteForm = $this->createDeleteForm($imgAcademy);

        return $this->render('imgacademy/show.html.twig', array(
            'imgAcademy' => $imgAcademy,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing imgAcademy entity.
     *
     * @Route("/{id}/edit", name="admin_imgacademy_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImgAcademy $imgAcademy)
    {
        $deleteForm = $this->createDeleteForm($imgAcademy);
        $editForm = $this->createForm('AppBundle\Form\ImgAcademyType', $imgAcademy);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_imgacademy_edit', array('id' => $imgAcademy->getId()));
        }

        return $this->render('imgacademy/edit.html.twig', array(
            'imgAcademy' => $imgAcademy,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a imgAcademy entity.
     *
     * @Route("/{id}", name="admin_imgacademy_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImgAcademy $imgAcademy)
    {
        $form = $this->createDeleteForm($imgAcademy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imgAcademy);
            $em->flush($imgAcademy);
        }

        return $this->redirectToRoute('admin_imgacademy_index');
    }

    /**
     * Creates a form to delete a imgAcademy entity.
     *
     * @param ImgAcademy $imgAcademy The imgAcademy entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImgAcademy $imgAcademy)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_imgacademy_delete', array('id' => $imgAcademy->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
