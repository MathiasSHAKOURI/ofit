<?php

namespace App\Repository;

use App\Entity\WorkoutParameter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkoutParameter>
 *
 * @method WorkoutParameter|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkoutParameter|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkoutParameter[]    findAll()
 * @method WorkoutParameter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkoutParameterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkoutParameter::class);
    }

    public function add(WorkoutParameter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WorkoutParameter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
