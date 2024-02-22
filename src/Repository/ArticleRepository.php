<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search(array $filters = [], array $order = [], int $limit = null, int $offset = null) 
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->leftJoin('a.articleCategory', 'c')
            ->leftJoin('a.user', 'u'); 
        
        if (array_key_exists('categories', $filters))
        {
            if (!empty($filters['categories']['category'])){
                $category = $filters['categories']['category'];
                $qb->andWhere('c.label = :category')
                    ->setParameter('category', $category);
            }
        }

        if (array_key_exists('published', $filters))
        {
            if (!empty($filters['published']['only'])){
                $qb->andWhere('a.publishedAt <= CURRENT_TIME()');
            }
        }

        if (array_key_exists('userInputs', $filters))
        {
            if (!empty($filters['userInputs']['userInput'])){
                $userInput = $filters['userInputs']['userInput'];
                $qb->andWhere('a.title like :userInput')
                    ->setParameter('userInput', "%{$userInput}%");
            }
        }

        if (array_key_exists('author', $filters))
        {
            if (!empty($filters['author']['authorId'])){
                $id = $filters['author']['authorId'];
                $qb->andWhere('u.id = :id')
                    ->setParameter('id', $id);
            }
        }

        if (!empty($order))
        {
            $sortField = key($order);
            $sortDirection = current($order);
    
            if (!empty($sortField) && !empty($sortDirection)){
                $qb->orderBy('a.' . $sortField, $sortDirection);
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

    public function countArticlesByCategory($sign)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->select('count(a) as count,c.label')
            ->leftJoin('a.articleCategory', 'c');

        if ($sign === '<=')
        {
            $queryBuilder->where('a.publishedAt <= CURRENT_TIME()');
        } 
        elseif ($sign === '>')
        {
            $queryBuilder->where('a.publishedAt > CURRENT_TIME()');
        };

        return $queryBuilder
            ->groupBy('c.label')
            ->getQuery()
            ->getResult();
        }
}
