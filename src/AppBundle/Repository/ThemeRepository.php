<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Discussion;

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

	function getLast($theme) {
		return $this->createQueryBuilder('t')
            ->from(Discussion::class, 'd')
            ->where('d.themeid = :themeid')
            ->setParameter('themeid', $theme)
            ->setMaxResults(1)
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult();
	}
}