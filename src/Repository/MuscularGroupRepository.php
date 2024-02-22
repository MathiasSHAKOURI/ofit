<?php

namespace App\Repository;

use App\Entity\MuscularGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MuscularGroup>
 *
 * @method MuscularGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method MuscularGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method MuscularGroup[]    findAll()
 * @method MuscularGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MuscularGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MuscularGroup::class);
    }

    public function add(MuscularGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MuscularGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
