<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Academy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Academy controller.
 *
 * @Route("admin/academy")
 */
class AcademyController extends Controller
{
    /**
     * Lists all academy entities.
     *
     * @Route("/", name="admin_academy_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $academies = $em->getRepository('AppBundle:Academy')->findAll();

        return $this->render('academy/index.html.twig', array(
            'academies' => $academies,
        ));
    }

    /**
     * Creates a new academy entity.
     *
     * @Route("/new", name="admin_academy_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $academy = new Academy();
        $form = $this->createForm('AppBundle\Form\AcademyType', $academy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($academy);
            $em->flush($academy);

            return $this->redirectToRoute('admin_academy_show', array('slug' => $academy->getSlug()));
        }

        return $this->render('academy/new.html.twig', array(
            'academy' => $academy,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a academy entity.
     *
     * @Route("/{slug}", name="admin_academy_show")
     * @Method("GET")
     */
    public function showAction(Academy $academy)
    {
        $deleteForm = $this->createDeleteForm($academy);

        return $this->render('academy/show.html.twig', array(
            'academy' => $academy,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing academy entity.
     *
     * @Route("/{slug}/edit", name="admin_academy_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Academy $academy)
    {
        $deleteForm = $this->createDeleteForm($academy);
        $editForm = $this->createForm('AppBundle\Form\AcademyType', $academy);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_academy_show', array('slug' => $academy->getSlug()));
        }

        return $this->render('academy/edit.html.twig', array(
            'academy' => $academy,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a academy entity.
     *
     * @Route("/{id}", name="admin_academy_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Academy $academy)
    {
        $form = $this->createDeleteForm($academy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($academy);
            $em->flush($academy);
        }

        return $this->redirectToRoute('admin_academy_index');
    }

    /**
     * Creates a form to delete a academy entity.
     *
     * @param Academy $academy The academy entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Academy $academy)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_academy_delete', array('id' => $academy->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
