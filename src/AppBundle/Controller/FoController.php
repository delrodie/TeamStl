<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * Liste des compétitions.
     *
     */
     public function accueilAction()
     {
         //$em = $this->getDoctrine()->getManager();

         //$competitions = $em->getRepository('AppBundle:Competition')->getAdmincalendrier();

         return $this->render('fr/index.html.twig');
     }
}
