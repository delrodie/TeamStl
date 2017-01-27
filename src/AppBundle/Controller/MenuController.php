<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Presentation;
use AppBundle\Entity\Avantage;
use AppBundle\Entity\Communaute;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class MenuController extends Controller
{

  /**
   * Menu de la rubrique presentation.
   *
   */
  public function presentationAction()
  {
      $em = $this->getDoctrine()->getManager();

      $presentations = $em->getRepository('AppBundle:Presentation')->findAll();

      return $this->render('menu/presentation.html.twig', array(
          'presentations' => $presentations,
      ));
  }

  /**
   * Menu de la rubrique initiation.
   *
   */
  public function initiationAction()
  {
      $em = $this->getDoctrine()->getManager();

      $initiations = $em->getRepository('AppBundle:Initiation')->findAll();

      return $this->render('menu/initiation.html.twig', array(
          'initiations' => $initiations,
      ));
  }

  /**
   * Menu de la rubrique academy.
   *
   */
  public function academyAction()
  {
      $em = $this->getDoctrine()->getManager();

      $academys = $em->getRepository('AppBundle:Academy')->findAll();

      return $this->render('menu/academy.html.twig', array(
          'academys' => $academys,
      ));
  }


}
