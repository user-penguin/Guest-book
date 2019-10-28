<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @param int $size
     * @param int $page
     * @return array
     */
    public function getEventsForPagination(int $size, int $page)
    {
        $qb = $this->createQueryBuilder('e');

        return $qb
            ->select('e.name')
            ->addSelect('e.id')
            ->addSelect('e.date')
            ->addSelect('e.description')
            ->addSelect('e.createdAt')


            ->setFirstResult(($page - 1) * $size)
            ->setMaxResults($size)

            ->getQuery()
            ->getArrayResult()
            ;
    }

    /**
     * @return int|mixed
     */
    public function getCountOfRecords()
    {
        $qb = $this->createQueryBuilder('e');

        try {
            return $qb
                ->select('count(e.id)')
                ->getQuery()
                ->getSingleScalarResult();

        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }


}
