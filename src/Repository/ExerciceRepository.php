<?php

namespace App\Repository;

use App\Entity\Exercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercice>
 *
 * @method Exercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exercice[]    findAll()
 * @method Exercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercice::class);
    }

    public function add(Exercice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Exercice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search(array $filters = [], array $order = [], int $limit = null, int $offset = null) 
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e')
            ->leftJoin('e.muscularGroup', 'm'); 
        
        if (array_key_exists('muscularGroup', $filters))
        {
            if (!empty($filters['muscularGroup']['label'])){
                $label = $filters['muscularGroup']['label'];
                $qb->andWhere('m.label = :muscularGroup')
                    ->setParameter('muscularGroup', $label);
            }
        }

        if (array_key_exists('userInputs', $filters))
        {
            if (!empty($filters['userInputs']['userInput'])){
                $userInput = $filters['userInputs']['userInput'];
                $qb->andWhere('e.title like :userInput')
                    ->setParameter('userInput', "%{$userInput}%");
            }
        }

        if (!empty($order))
        {
            $sortField = key($order);
            $sortDirection = current($order);
    
            if (!empty($sortField) && !empty($sortDirection)){
                $qb->orderBy('e.' . $sortField, $sortDirection);
            }
        }

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }
    
        if ($offset !== null) {
            $qb->setFirstResult($offset);
        }
        
        return $qb
            ->getQuery()
            ->getResult();
    }

    public function countExercices()
    {
        return $this->createQueryBuilder('e')
        ->select('count(e) as count')
        ->getQuery()
        ->getSingleScalarResult();
    }
}
