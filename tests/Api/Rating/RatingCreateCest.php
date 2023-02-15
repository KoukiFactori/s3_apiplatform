<?php

namespace App\Tests\Api\Rating;

use App\Factory\BookmarkFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class RatingCreateCest
{
    public function postRatingAnonymous(ApiTester $I): void
    {
        BookmarkFactory::createOne();
        UserFactory::createOne(['login' => 'user1', 'password' => 'test']);

        $I->sendPost('/api/ratings', [
          'user' => '/api/users/1',
          'bookmark' => '/api/bookmarks/1',
          'value' => 5,
        ]);

        $I->seeResponseCodeIs(401);
    }

    public function postRatingAuthenticated(ApiTester $I): void
    {
        $bookmark = BookmarkFactory::createOne();
        $user = UserFactory::createOne(['login' => 'user1', 'password' => 'test'])->object();
        $I->amLoggedInAs($user);

        $I->sendPost('/api/ratings', [
          'user' => '/api/users/'.$user->getId(),
          'bookmark' => '/api/bookmarks/'.$bookmark->getId(),
          'value' => 5,
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function postRatingAgain(ApiTester $I): void
    {
        $bookmark = BookmarkFactory::createOne();
        $user = UserFactory::createOne(['login' => 'user1', 'password' => 'test'])->object();
        $I->amLoggedInAs($user);

        $I->sendPost('/api/ratings', [
          'user' => '/api/users/'.$user->getId(),
          'bookmark' => '/api/bookmarks/'.$bookmark->getId(),
          'value' => 5,
        ]);
        $I->seeResponseCodeIs(201);

        $I->sendPost('/api/ratings', [
          'user' => '/api/users/'.$user->getId(),
          'bookmark' => '/api/bookmarks/'.$bookmark->getId(),
          'value' => 5,
        ]);
        $I->seeResponseCodeIs(422);
    }

    public function postRatingForSomeoneElse(ApiTester $I): void
    {
        $target = UserFactory::createOne(); // User we want to use for post

        $bookmark = BookmarkFactory::createOne();
        $user = UserFactory::createOne(['login' => 'user1', 'password' => 'test'])->object();
        $I->amLoggedInAs($user);

        $I->sendPost('/api/ratings', [
          'user' => '/api/users/'.$target->getId(),
          'bookmark' => '/api/bookmarks/'.$bookmark->getId(),
          'value' => 5,
        ]);
        $I->seeResponseCodeIs(422);
    }
}
