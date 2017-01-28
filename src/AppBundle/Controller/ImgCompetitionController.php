<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ImgCompetition;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Imgcompetition controller.
 *
 * @Route("admin/imgcompetition")
 */
class ImgCompetitionController extends Controller
{
    /**
     * Lists all imgCompetition entities.
     *
     * @Route("/", name="admin_imgcompetition_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imgCompetitions = $em->getRepository('AppBundle:ImgCompetition')->findAll();

        return $this->render('imgcompetition/index.html.twig', array(
            'imgCompetitions' => $imgCompetitions,
        ));
    }

    /**
     * Creates a new imgCompetition entity.
     *
     * @Route("/new", name="admin_imgcompetition_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imgCompetition = new Imgcompetition();
        $form = $this->createForm('AppBundle\Form\ImgCompetitionType', $imgCompetition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imgCompetition);
            $em->flush($imgCompetition);

            return $this->redirectToRoute('admin_imgcompetition_show', array('id' => $imgCompetition->getId()));
        }

        return $this->render('imgcompetition/new.html.twig', array(
            'imgCompetition' => $imgCompetition,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a imgCompetition entity.
     *
     * @Route("/{id}", name="admin_imgcompetition_show")
     * @Method("GET")
     */
    public function showAction(ImgCompetition $imgCompetition)
    {
        $deleteForm = $this->createDeleteForm($imgCompetition);

        return $this->render('imgcompetition/show.html.twig', array(
            'imgCompetition' => $imgCompetition,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing imgCompetition entity.
     *
     * @Route("/{id}/edit", name="admin_imgcompetition_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImgCompetition $imgCompetition)
    {
        $deleteForm = $this->createDeleteForm($imgCompetition);
        $editForm = $this->createForm('AppBundle\Form\ImgCompetitionType', $imgCompetition);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_imgcompetition_edit', array('id' => $imgCompetition->getId()));
        }

        return $this->render('imgcompetition/edit.html.twig', array(
            'imgCompetition' => $imgCompetition,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a imgCompetition entity.
     *
     * @Route("/{id}", name="admin_imgcompetition_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImgCompetition $imgCompetition)
    {
        $form = $this->createDeleteForm($imgCompetition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imgCompetition);
            $em->flush($imgCompetition);
        }

        return $this->redirectToRoute('admin_imgcompetition_index');
    }

    /**
     * Creates a form to delete a imgCompetition entity.
     *
     * @param ImgCompetition $imgCompetition The imgCompetition entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImgCompetition $imgCompetition)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_imgcompetition_delete', array('id' => $imgCompetition->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
