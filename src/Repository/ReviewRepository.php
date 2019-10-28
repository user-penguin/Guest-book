<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    /**
     * @param int $eventId
     * @param int $size
     * @param int $page
     * @return array
     */
    public function getEventsForPagination(int $eventId, int $size, int $page)
    {
        $qb = $this->createQueryBuilder('r');

        return $qb
            ->join('r.user', 'user')
            ->join('r.event', 'event')

            ->select('r.id')
            ->addSelect('r.text')
            ->addSelect('r.rate')
            ->addSelect('user.username')

            ->where('event.id = :eventId')

            ->setParameter('eventId', $eventId)
            ->setFirstResult(($page - 1) * $size)
            ->setMaxResults($size)

            ->getQuery()
            ->getArrayResult()
            ;
    }

    /**
     * @param int $eventId
     * @return int|mixed
     */
    public function getCountOfRecords(int $eventId)
    {
        dump($eventId);
        $qb = $this->createQueryBuilder('r');

        $count = $qb
            ->join('r.event', 'event')

            ->select('count(r.id) as count')
            ->addSelect('event.id')

            ->where('event.id = :eventId')

            ->groupBy('event.id')

            ->setParameter('eventId', $eventId)

            ->getQuery()
            ->getArrayResult()
        ;

        if (!isset($count[0]['count'])) {
            return 0;
        }

        return $count[0]['count'];
    }
}
