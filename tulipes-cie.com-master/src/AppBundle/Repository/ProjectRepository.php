<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{

    public function findAllWithFilters(array $filters)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->orderBy("p.createdAt", "DESC");
        $qb->andWhere("p.isNotShow = false");
        if (count($filters) > 0) {
            foreach ($filters as $key => $filter) {
                $qb
                    ->innerJoin("p.filters", "f$key", "WITH", "f$key.id = :filter_$key")
                    ->setParameter("filter_$key", $filter)
                ;
            }

        }
        return $qb->getQuery()->getResult();
    }

    public function findProjectsByLimit($first, $last)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->orderBy("p.createdAt", "DESC")
            ->setFirstResult($first)
            ->setMaxResults($last);
        return $qb->getQuery()->getResult();
    }


}