<?php

namespace App\Repository;

use App\Entity\TestUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestUsers>
 *
 * @method TestUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestUsers[]    findAll()
 * @method TestUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestUsers::class);
    }

    public function save(TestUsers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TestUsers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    //    /**
//     * @return TestUsers[]
//     */
    public function findAllBySearchFields($isActive, $isMember, $lastLoginFrom, $lastLoginTo, $userTypes): array
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->select(
                'u.id',
                'u.username',
                'u.email',
                'u.password',
                'u.is_member',
                'u.is_active',
                'u.user_type',
                'u.last_login_at',
                'u.created_at',
                'u.updated_at'
            )
            ->where('1=1');

        if ($isActive) {
            $queryBuilder->andWhere('u.is_active = :is_active')
                ->setParameter('is_active', true);
        }

        if ($isMember) {
            $queryBuilder->andWhere('u.is_member = :is_member')
                ->setParameter('is_member', true);
        }

        if ($lastLoginFrom) {
            $queryBuilder->andWhere('u.last_login_at >= :lastLoginFrom')
                ->setParameter('lastLoginFrom', new \DateTime($lastLoginFrom));
        }

        if ($lastLoginTo) {
            $queryBuilder->andWhere('u.last_login_at <= :lastLoginTo')
                ->setParameter('lastLoginTo', new \DateTime($lastLoginTo . ' 23:59:59'));
        }

        if (!empty($userTypes)) {
            $queryBuilder->andWhere('u.user_type IN (:user_type)')
                ->setParameter('user_type', $userTypes);
        }

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

//    /**
//     * @return TestUsers[] Returns an array of TestUsers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TestUsers
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
