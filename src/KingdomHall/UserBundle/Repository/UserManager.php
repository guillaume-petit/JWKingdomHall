<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 8/19/15
 * Time: 10:25 AM
 */

namespace KingdomHall\UserBundle\Repository;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use FOS\UserBundle\Model\UserInterface;
use KingdomHall\UserBundle\Entity\User;

class UserManager extends \FOS\UserBundle\Doctrine\UserManager
{
    public function updateCanonicalFields(UserInterface $user)
    {
        parent::updateCanonicalFields($user);
        if ($user instanceof User) {
            $user->getPublisher()->setEmail($user->getEmailCanonical());
        }
    }


    public function searchUser($pagination, $sort, $search)
    {
        $response = array (
            'total' => 0,
            'rows'  => array(),
        );

        $em = $this->objectManager;
        if ($em instanceof EntityManager) {
            if ($sort['sort'] == 'publisher.fullName') {
                $sort['sort'] = 'p.lastName';
            } else {
                $sort['sort'] = 'u.'.$sort['sort'];
            }

            $builder = $em->createQueryBuilder()
                ->select('u')
                ->from('KingdomHallUserBundle:User', 'u')
                ->leftJoin('u.publisher', 'p');

            $builder->orderBy($sort['sort'], $sort['order']);

            $builder->setMaxResults($pagination['limit'])
                ->setFirstResult($pagination['offset']);

            if ($search) {
                $where = $builder->expr()->orX();
                $where->add($builder->expr()->like('u.username', $builder->expr()->literal('%' . $search . '%')));
                $where->add($builder->expr()->like('u.email', $builder->expr()->literal('%' . $search . '%')));
                $where->add($builder->expr()->like('u.roles', $builder->expr()->literal('%' . $search . '%')));
                $where->add($builder->expr()->like('p.firstName', $builder->expr()->literal('%' . $search . '%')));
                $where->add($builder->expr()->like('p.lastName', $builder->expr()->literal('%' . $search . '%')));

                $builder->andWhere($where);
            }
            $query = $builder->getQuery();

            $paginator = new Paginator($query);

            $territories = $query->getResult();
            $response['total'] = count($paginator);
            $response['rows'] = $territories;
        }

        return $response;
    }
}