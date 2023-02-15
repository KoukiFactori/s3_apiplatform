<?php

namespace App\Tests\Api\Rating;

use App\Factory\BookmarkFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class RatingPutCest
{
    public function putRatingAnonymous(ApiTester $I)
    {
        RatingFactory::createOne();

        $I->sendPut('/api/ratings/1', [
          'user' => '/api/users/1',
          'bookmark' => '/api/bookmarks/1',
          'value' => 3,
        ]);

        $I->seeResponseCodeIs(401);
    }

    public function putRatingNotOwning(ApiTester $I)
    {
        RatingFactory::createOne();

        $user = UserFactory::createOne(['login' => 'user1'])->object();
        $I->amLoggedInAs($user);

        $I->sendPut('/api/ratings/1', [
          'user' => '/api/users/1',
          'bookmark' => '/api/bookmarks/1',
          'value' => 10,
        ]);

        $I->seeResponseCodeIs(403);
    }

    public function putRatingOwning(ApiTester $I)
    {
        $bookmark = BookmarkFactory::createOne();

        $user = UserFactory::createOne(['login' => 'user1'])->object();
        $I->amLoggedInAs($user);

        RatingFactory::createOne([
          'user' => $user,
          'bookmark' => $bookmark,
        ]);

        $I->sendPut('/api/ratings/1', [
          'user' => '/api/users/1',
          'bookmark' => '/api/bookmarks/1',
          'value' => 10,
        ]);

        $I->seeResponseCodeIs(200);
    }
}
