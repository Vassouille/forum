<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Theme;
/**
 * DiscussionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DiscussionRepository extends \Doctrine\ORM\EntityRepository
{
    function countDiscussion($id) {
        return $this->createQueryBuilder('d')
            ->where("d.themeid = $id")
            ->select('COUNT(d.id)')
            ->getQuery()
            ->getResult();
    }

    function getList($id, $page) {
        return $this->createQueryBuilder('d')
            ->where("d.themeid = $id")
            ->setFirstResult($page*10-10)
            ->setMaxResults(10)
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    function updateTheme($id, $lastusername, $lastdate) {
        /*$this->createQueryBuilder('a')
            ->update('AppBundle:Theme', 't')
            ->set('t.lastusername', );*/
    }
}
