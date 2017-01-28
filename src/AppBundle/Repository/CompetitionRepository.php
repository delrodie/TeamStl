<?php

namespace AppBundle\Repository;

/**
 * CompetitionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompetitionRepository extends \Doctrine\ORM\EntityRepository
{
  /**
  * Recherche de la liste des compétitions
  *
  * Author: Delrodie AMOIKON
  * Date: 28/01/2017
  * Since: v1.0
  */
  public function getAdmincalendrier()
  {
      $em = $this->getEntityManager();
      $qb = $em->createQuery('
          SELECT c
          FROM AppBundle:Competition c
          ORDER BY c.datedeb DESC
      ')
      ;
      try {
          $result = $qb->getResult();

          return $result;

      } catch (NoResultException $e) {
          return $e;
      }

  }
}
