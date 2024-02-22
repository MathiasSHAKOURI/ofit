<?php

namespace App\Repository;

use App\Entity\WorkoutProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class WorkoutProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkoutProgram::class);
    }

    public function add(WorkoutProgram $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WorkoutProgram $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countWorkoutProgram($sign)
    {
        $queryBuilder = $this->createQueryBuilder('w')
        ->select('count(w) as count');

        if ($sign === '<=')
        {
            $queryBuilder->where('w.publishedAt <= CURRENT_TIME()');
        } 
        elseif ($sign === '>')
        {
            $queryBuilder->where('w.publishedAt > CURRENT_TIME()');
        };

        return $queryBuilder
        ->getQuery()
        ->getSingleScalarResult();
    }

    public function search(array $filters = [], array $order = [], int $limit = null, int $offset = null) 
    {
        $qb = $this->createQueryBuilder('w')
            ->select('w')
            ->leftJoin('w.user', 'u') 
            ->leftJoin('w.workoutCategory', 'c');

        if (array_key_exists('published', $filters))
        {
            if (!empty($filters['published']['only'])){
                $qb->andWhere('w.publishedAt <= CURRENT_TIME()');
            }
        }

        if (array_key_exists('userInputs', $filters))
        {
            if (!empty($filters['userInputs']['userInput'])){
                $userInput = $filters['userInputs']['userInput'];
                $qb->andWhere('w.title like :userInput')
                    ->orWhere('c.label like :userInput')
                    ->setParameter('userInput', "%{$userInput}%");
            }

            if (!empty($filters['userInputs']['category'])){
                $category = $filters['userInputs']['category'];
                $qb->andWhere('c.id = :category')
                    ->setParameter('category', $category);
            }

            if (!empty($filters['userInputs']['min'])){
                $min = $filters['userInputs']['min'];
                $qb->andWhere('w.duration >= :min')
                    ->setParameter('min', $min);
            }

            if (!empty($filters['userInputs']['max'])){
                $max = $filters['userInputs']['max'];
                $qb->andWhere('w.duration <= :max')
                    ->setParameter('max', $max);
            }
        }

        if (array_key_exists('category', $filters))
        {
            if (!empty($filters['category']['categoryId'])){
                $id = $filters['category']['categoryId'];
                $qb->andWhere('c.id = :categoryId')
                    ->setParameter('categoryId', $id);
            }
        }

        if (array_key_exists('author', $filters))
        {
            if (!empty($filters['author']['authorId'])){
                $id = $filters['author']['authorId'];
                $qb->andWhere('u.id = :authorId')
                    ->setParameter('authorId', $id);
            }
        }

        if (array_key_exists('min', $filters)) {
            if (!empty($filters['min']['min'])) {
                $min = $filters['min']['min'];
                $qb->andWhere('w.duration >= :min')
                    ->setParameter('min', $min);
            }
        }

        if (array_key_exists('max', $filters)) {
            if (!empty($filters['max']['max'])){
                $max = $filters['max']['max'];
                $qb->andWhere('w.duration <= :max')
                    ->setParameter('max', $max);
            }
        }

        if (!empty($order))
        {
            $sortField = key($order);
            $sortDirection = current($order);

            if (!empty($sortField) && !empty($sortDirection)){
                $qb->orderBy('w.' . $sortField, $sortDirection);
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
}
