<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Contact::class);
        $this->paginator = $paginator;
    }


    /**
     * @return Contact[] Returns an array of Contact objects
     */

    public function findAllPaginated(int $page, string $sortBy = '', string $search='')
    {   

        $queryBuilder =  $this->createQueryBuilder('c');

        $searchTerms = $this->prepareSearch($search);
        foreach ($searchTerms as $key => $term) {
            $queryBuilder->orWhere('c.firstName LIKE :t_'.$key);
            $queryBuilder->orWhere('c.lastName LIKE :t_'.$key);
            $queryBuilder->setParameter('t_'.$key, '%'.trim($term).'%');
        }

        [$field, $order ] = $this->prepareSort($sortBy);
        $queryBuilder->orderBy("c.{$field}", $order);
        $dbquery = $queryBuilder->getQuery();

        $pagination = $this->paginator->paginate($dbquery, 1, 10);
        return $pagination;
    }

    private function prepareSort($sortBy) : array
    {
        $sort_fields = ['firstName', 'lastName'];
        $sort_methods = ['ASC', 'DESC'];
        $field = 'firstName';
        $order = 'ASC';
        // Ensure sorting parameters correspond to defined ones
        if (!empty($sortBy)) {
            $sort = explode('-', $sortBy);
            if (count($sort) > 1) {    
                if (in_array($sort[0], $sort_fields) && in_array(strtoupper($sort[1]), $sort_methods)) {
                    $field = $sort[0];
                    $order = mb_strtoupper($sort[1]);
                }
            }
        }
        return [$field, $order];
    }

    private function prepareSearch($search): array
    {
        if(!empty($search))
        return explode(' ', $search);
        else return [];
    }
}