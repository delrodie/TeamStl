<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FoController extends Controller
{

    /**
     * Liste des compétitions.
     *
     */
     public function accueilAction()
     {
         return $this->render('fr/index.html.twig');
     }

     /**
     * Recherche des articles actifs de l'entité presentation.
     *
     */
    public function presentationAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $presentations = $em->getRepository('AppBundle:Presentation')->getArticle($slug);

        return $this->render('fr/presentation.html.twig', array(
            'presentations' => $presentations,
        ));
    }

    /**
    * Recherche des articles actifs de l'entité initiation au golf.
    *
    */
   public function initiationAction($slug)
   {
       $em = $this->getDoctrine()->getManager();

       $initiations = $em->getRepository('AppBundle:Initiation')->getArticle($slug);

       return $this->render('fr/initiation.html.twig', array(
           'initiations' => $initiations,
       ));
   }

   /**
   * Recherche des articles actifs de l'entité golf academy.
   *
   */
  public function academyAction($slug)
  {
      $em = $this->getDoctrine()->getManager();

      $academys = $em->getRepository('AppBundle:Academy')->getArticle($slug);

      return $this->render('fr/academy.html.twig', array(
          'academys' => $academys,
      ));
  }

  /**
  * Recherche des articles actifs de l'entité compétition.
  *
  */
 public function competitionAction($slug)
 {
     $em = $this->getDoctrine()->getManager();

     $competitions = $em->getRepository('AppBundle:Competition')->getArticle($slug);

     return $this->render('fr/competition.html.twig', array(
         'competitions' => $competitions,
     ));
 }

   /**
   * Recherche des articles actifs de l'entité compétition.
   *
   */
  public function calendriercompetitionAction()
  {
      $em = $this->getDoctrine()->getManager();

      $competitions = $em->getRepository('AppBundle:Competition')->getCompetition();

      return $this->render('fr/competitioncalendrier.html.twig', array(
          'competitions' => $competitions,
      ));
  }

    /**
    * Recherche des articles actifs de l'entité compétition.
    *
    */
   public function societeAction($slug)
   {
       $em = $this->getDoctrine()->getManager();

       $societes = $em->getRepository('AppBundle:Societe')->getArticle($slug);

       return $this->render('fr/societe.html.twig', array(
           'societes' => $societes,
       ));
   }

   /**
   * Recherche des articles actifs de l'entité compétition.
   *
   */
  public function calendrierevenementAction()
  {
      $em = $this->getDoctrine()->getManager();

      $evenements = $em->getRepository('AppBundle:Evenement')->getEvenement();

      return $this->render('fr/evenementcalendrier.html.twig', array(
          'evenements' => $evenements,
      ));
  }


     /**
     * Recherche des photos .
     *
     */
    public function photoalbumsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $albums = $em->getRepository('AppBundle:Phototheque')->getAlbums();

        return $this->render('fr/photothequealbums.html.twig', array(
            'albums' => $albums,
        ));
    }

    /**
    * Recherche des photos .
    *
    */
   public function photothequeAction($slug)
   {
       $em = $this->getDoctrine()->getManager();

       $phototheques = $em->getRepository('AppBundle:Phototheque')->getArticle($slug);

       return $this->render('fr/phototheque.html.twig', array(
           'phototheques' => $phototheques,
       ));
   }
}
