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

    
}
