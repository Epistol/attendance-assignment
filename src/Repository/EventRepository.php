<?php

namespace App\Repository;

use App\Entity\Event;
use Carbon\Carbon;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @param $value = Current time
     * @return DateTime
     */

    public function findBetweenDateOneHour($value)
    {
        $prev = $this->roundToHour($value, "PREV");
        $next = $this->roundToHour($value, "NEXT");


        return $this->createQueryBuilder('e')
            ->andWhere('e.Date BETWEEN :prev AND :next ')
            ->setParameter('prev', $prev->format('Y-m-d H:i'))
            ->setParameter('next', $next->format('Y-m-d H:i'))
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $dateString
     * @param $next_or_prev
     * @return DateTime
     */
    private function roundToHour($dateString, $next_or_prev) {
        $date = new DateTime($dateString);
        $minutes = $date->format('i');
        if ($minutes > 0) {
            if($next_or_prev == "NEXT"){
                $date->modify("+1 hour");
            }


            $date->modify('-'.$minutes.' minutes');
        }
        return $date;
    }

}
