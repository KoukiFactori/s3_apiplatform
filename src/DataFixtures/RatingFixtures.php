<?php

namespace App\DataFixtures;

use App\Factory\BookmarkFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RatingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (UserFactory::all() as $user) {
            RatingFactory::createMany(rand(3, 7), [
                'user' => $user,
                'bookmark' => BookmarkFactory::random(),
            ]);
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            BookmarkFixtures::class,
        ];
    }
}
