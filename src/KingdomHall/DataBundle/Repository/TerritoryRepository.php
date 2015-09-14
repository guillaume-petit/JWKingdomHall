<?php

namespace KingdomHall\DataBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use KingdomHall\DataBundle\Entity\Territory;

class TerritoryRepository extends EntityRepository {

    public function searchTerritories($congregation, $type, $pagination, $sort, $search = '')
    {
        // Map date sorting
        if ($sort['sort'] == 'formattedBorrowDate') {
            $sort['sort'] = 't.borrowDate';
        } elseif ($sort['sort'] == 'formattedReturnDate') {
            $sort['sort'] = 't.returnDate';
        } elseif ($sort['sort'] == 'publisher.fullName') {
            $sort['sort'] = 'p.lastName';
        } else {
            $sort['sort'] = 't.'.$sort['sort'];
        }

        $builder = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('KingdomHallDataBundle:Territory', 't')
            ->leftJoin('t.publisher', 'p')
            ->where('t.type = :type')
            ->andWhere('t.congregation = :congregation')
            ->setParameter('type', $type)
            ->setParameter('congregation', $congregation);

        // Set order
        $builder
            ->orderBy($sort['sort'], $sort['order']);

        // Set pagination
        $builder->setMaxResults($pagination['limit'])
            ->setFirstResult($pagination['offset']);

        // Set search
        if ($search) {
            if (strpos($search, '*') !== false) {
                $search = str_replace('*', '%', $search);
            } else {
                $search = '%'.$search.'%';
            }
            $where = $builder->expr()->orX();
            $where->add($builder->expr()->like('t.number', $builder->expr()->literal($search)));
            $where->add($builder->expr()->like('t.name', $builder->expr()->literal($search)));
            $where->add($builder->expr()->like('t.area', $builder->expr()->literal($search)));
            $where->add($builder->expr()->like('p.firstName', $builder->expr()->literal($search)));
            $where->add($builder->expr()->like('p.lastName', $builder->expr()->literal($search)));

            $builder->andWhere($where);
        }
        $query = $builder->getQuery();

        $paginator = new Paginator($query);

        $territories = $query->getResult();
        $response  = array (
            'total' => count($paginator),
            'rows' => $territories,
        );

        return $response;
    }

}