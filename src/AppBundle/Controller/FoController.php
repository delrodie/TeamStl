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
}
