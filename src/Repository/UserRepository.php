<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }    

    public function search(array $filters = [], array $order = [], int $limit = null, int $offset = null) 
    {
        $qb = $this->createQueryBuilder('u');
        
        if (array_key_exists('roles', $filters))
        {
            if (!empty($filters['roles']['role'])){
                $role = '"ROLE_' . $filters['roles']['role'] . '"';
                $qb->andWhere('JSON_CONTAINS(u.roles, :role, \'$\') = 1')
                    ->setParameter('role', $role);
            }
        }

        if (array_key_exists('userInputs', $filters))
        {
            if (!empty($filters['userInputs']['userInput'])){
                $userInput = $filters['userInputs']['userInput'];
                $qb->andWhere('u.firstname like :userInput')
                    ->orWhere('u.lastname like :userInput')
                    ->orWhere('u.pseudo like :userInput')
                    ->setParameter('userInput', "%{$userInput}%");
            }
        }
    
        if (!empty($order))
        {
            $sortField = key($order);
            $sortDirection = current($order);
    
            if (!empty($sortField) && !empty($sortDirection)){
                $qb->orderBy('u.' . $sortField, $sortDirection);
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
