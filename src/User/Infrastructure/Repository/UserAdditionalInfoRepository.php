<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Model\UserAdditionalInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAdditionalInfo>
 *
 * @method UserAdditionalInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAdditionalInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAdditionalInfo[]    findAll()
 * @method UserAdditionalInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAdditionalInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAdditionalInfo::class);
    }

    public function save(UserAdditionalInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserAdditionalInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserAdditionalInfo[] Returns an array of UserAdditionalInfo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserAdditionalInfo
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
