<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\Rating;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;

#[AsEntityListener(
    event: Events::prePersist,
    entity: Rating::class
)]
class RatingSetUserListener
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(Rating $rating)
    {
        if (null === $rating->getUser()) {
            $rating->setUser($this->security->getUser());
        }
    }
}
