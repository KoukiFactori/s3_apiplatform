<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\Rating;
use App\Repository\BookmarkRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;

class BookmarkRateAverageUpdateListener
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function updateRateAverage(Rating $rating): void
    {
        /**
         * @var BookmarkRepository $rep
         */
        $rep = $this->entityManager->getRepository(BookmarkRepository::class);

        $rep->updateRateAverage($rating->getBookmark()->getId());
    }

    #[AsEntityListener(
        event: Events::postPersist,
        entity: Rating::class
    )]
    public function postPersist(Rating $rating): void
    {
        $this->updateRateAverage($rating);
    }

    #[AsEntityListener(
        event: Events::postRemove,
        entity: Rating::class
    )]
    public function postRemove(Rating $rating): void
    {
        $this->updateRateAverage($rating);
    }

    #[AsEntityListener(
        event: Events::postUpdate,
        entity: Rating::class
    )]
    public function postUpdate(Rating $rating): void
    {
        $this->updateRateAverage($rating);
    }
}
