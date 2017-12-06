<?php

namespace AppBundle\Repository;

class ThemeRepository extends \Doctrine\ORM\EntityRepository
{
    function countTheme() {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->getQuery()
            ->getResult();
    }
    function getList($page) {
        return $this->createQueryBuilder('t')
            ->setFirstResult($page*5-5)
            ->setMaxResults(5)
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}