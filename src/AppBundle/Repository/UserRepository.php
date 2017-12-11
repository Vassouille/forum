<?php

namespace AppBundle\Repository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    function getActive()
    {
        $delay = new \DateTime();
        $delay->setTimestamp(strtotime('30 seconds ago'));

        $qb = $this->createQueryBuilder('u')
            ->select('count(u)')
            ->where('u.lastActivityAt > :delay')
            ->setParameter('delay', $delay)
        ;

        return $qb->getQuery()->getResult();
    }
}