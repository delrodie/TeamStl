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

  /**
   * Menu de la rubrique societe.
   *
   */
  public function societeAction()
  {
      $em = $this->getDoctrine()->getManager();

      $societes = $em->getRepository('AppBundle:Societe')->findAll();

      return $this->render('menu/societe.html.twig', array(
          'societes' => $societes,
      ));
  }

  /**
   * Menu de la rubrique competition.
   *
   */
  public function competitionAction()
  {
      $em = $this->getDoctrine()->getManager();

      $competitions = $em->getRepository('AppBundle:Competition')->findAll();

      return $this->render('menu/competition.html.twig', array(
          'competitions' => $competitions,
      ));
  }

  /**
  * *******************
  * MENU DU FRONTOFFICE
  * *******************
  */


  /**
   * Menu de la rubrique presentation.
   *
   */
  public function fopresentationAction()
  {
      $em = $this->getDoctrine()->getManager();

      $presentations = $em->getRepository('AppBundle:Presentation')->getMenu();

      return $this->render('menu/fopresentation.html.twig', array(
          'presentations' => $presentations,
      ));
  }

  /**
   * Menu de la rubrique presentation.
   *
   */
  public function foinitiationAction()
  {
      $em = $this->getDoctrine()->getManager();

      $initiations = $em->getRepository('AppBundle:Initiation')->getMenu();

      return $this->render('menu/foinitiation.html.twig', array(
          'initiations' => $initiations,
      ));
  }

  /**
   * Menu de la rubrique academy.
   *
   */
  public function foacademyAction()
  {
      $em = $this->getDoctrine()->getManager();

      $academys = $em->getRepository('AppBundle:Academy')->getMenu();

      return $this->render('menu/foacademy.html.twig', array(
          'academys' => $academys,
      ));
  }

  /**
   * Menu de la rubrique competition.
   *
   */
  public function focompetitionAction()
  {
      $em = $this->getDoctrine()->getManager();

      $competitions = $em->getRepository('AppBundle:Competition')->getCompetition();

      return $this->render('menu/focompetition.html.twig', array(
          'competitions' => $competitions,
      ));
  }

}
