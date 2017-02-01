<?php

namespace AppBundle\Repository;

/**
 * AcademyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AcademyRepository extends \Doctrine\ORM\EntityRepository
{
  /**
    * Requête de recherche du menu de la rubrique initiation
    *
    * Author: Delrodie AMOIKON
    * Date: 01/02/2017
    * Since: v1.0
    */
    public function getMenu()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQuery('
            SELECT a
            FROM AppBundle:Academy a
            WHERE a.statut = :stat
        ')
          ->setParameter('stat', 1)
        ;
        try {
            $result = $qb->getResult();

            return $result;

        } catch (NoResultException $e) {
            return $e;
        }
    }

    /**
    * Recherche de l'article de la rubrique academy
    *
    * Author: Delrodie AMOIKON
    * Date: 01/02/2017
    * Since: v1.0
    */
    public function getArticle($slug)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQuery('
            SELECT a
            FROM AppBundle:Academy a
            WHERE a.slug LIKE :slug
            AND a.statut = :stat
        ')
          ->setParameter('slug', '%'.$slug.'%')
          ->setParameter('stat', 1)
        ;
        try {
            $result = $qb->getResult();

            return $result;

        } catch (NoResultException $e) {
            return $e;
        }

    }
}
