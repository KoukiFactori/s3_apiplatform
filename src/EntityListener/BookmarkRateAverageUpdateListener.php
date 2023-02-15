<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\Rating;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(
    event: Events::prePersist,
    entity: Rating::class
)]
class RatingSetUserListener
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function updateRateAverage(Rating $rating): void {}
    public function postPersist(Rating $rating): void {}
    public function postRemove(Rating $rating): void {}
    public function postUpdate(Rating $rating): void  {}
}
