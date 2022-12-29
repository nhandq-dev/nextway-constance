<?php

namespace App\Repository;

use App\Entity\UserDailyEmotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserDailyEmotion>
 *
 * @method UserDailyEmotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDailyEmotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDailyEmotion[]    findAll()
 * @method UserDailyEmotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDailyEmotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDailyEmotion::class);
    }

    public function save(UserDailyEmotion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserDailyEmotion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return UserDailyEmotion[] Returns an array of UserDailyEmotion objects
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

    //    public function findOneBySomeField($value): ?UserDailyEmotion
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
