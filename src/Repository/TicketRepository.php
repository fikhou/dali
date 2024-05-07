<?php

namespace App\Repository;
use App\Entity\Event;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TicketRepository extends ServiceEntityRepository
{
   


    
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Ticket::class);
        }
    
        public function countTicketsByEvent(Event $event): int
        {
            return $this->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.event = :event')
                ->setParameter('event', $event)
                ->getQuery()
                ->getSingleScalarResult();
        }
    
    // Add custom repository methods here
}

