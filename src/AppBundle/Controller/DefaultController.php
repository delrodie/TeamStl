<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('fr/index.html.twig');
    }

    /**
     *
     */
    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * Liste des compétitions.
     *
     */
     public function calendrierAction()
     {
         $em = $this->getDoctrine()->getManager();

         $competitions = $em->getRepository('AppBundle:Competition')->getAdmincalendrier();

         return $this->render('competition/calendrier.html.twig', array(
             'competitions' => $competitions,
         ));
     }

     /**
      * Liste des compétitions.
      *
      */
      public function competitionAction()
      {
          $em = $this->getDoctrine()->getManager();

          $competitions = $em->getRepository('AppBundle:Competition')->getCompetition();

          return $this->render('fr/competitionliste.html.twig', array(
              'competitions' => $competitions,
          ));
      }

      /**
       * Liste des compétitions.
       *
       */
       public function accueilcompetitionAction()
       {
           $em = $this->getDoctrine()->getManager();

           $competitions = $em->getRepository('AppBundle:Competition')->getCompetition();

           return $this->render('fr/competitionaccueil.html.twig', array(
               'competitions' => $competitions,
           ));
       }

       /**
        * Liste des compétitions.
        *
        */
        public function existencecompetitionAction()
        {
            $em = $this->getDoctrine()->getManager();

            $competitions = $em->getRepository('AppBundle:Competition')->getCompetition();

            return $this->render('fr/competitionexistence.html.twig', array(
                'competitions' => $competitions,
            ));
        }
}
