<?php

namespace App\Repository;

use App\Entity\Forumsponsor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ForumsponsorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forumsponsor::class);
    }

    // Add custom query methods here
}
