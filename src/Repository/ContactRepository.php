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

    // /**
    //  * @return Contact[] Returns an array of Contact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @return Contact[] Returns an array of Contact objects
    */
    
    public function findAllPaginated($page)
    {
       $dbquery =  $this->createQueryBuilder('c')
            ->getQuery();

            $pagination = $this->paginator->paginate($dbquery, $page, 10);
            return $pagination;
    }
    
}