<?php

namespace App\Tests\Api\Rating;

use App\Factory\BookmarkFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class BookmarkRateAverageCest
{
    public function defaultBookmarkRate(ApiTester $I)
    {
        $bookmark = BookmarkFactory::createOne();

        $I->expect(0 == $bookmark->getRateAverage());
    }

    public function createRatingUpdatesBookmarkRate(ApiTester $I)
    {
        $bookmark = BookmarkFactory::createOne();
        $user = UserFactory::createOne(['login' => 'user1', 'password' => 'test']);
        $I->amLoggedInAs($user->object());

        $I->sendPost('/api/ratings', [
          'bookmark' => '/api/bookmarks/1',
          'value' => 6,
        ]);

        $I->expect(6 == $bookmark->getRateAverage());
    }

    public function patchRatingUpdatesBookmarkRate(ApiTester $I)
    {
        $bookmark = BookmarkFactory::createOne();
        $user = UserFactory::createOne(['login' => 'user1', 'password' => 'test']);
        $I->amLoggedInAs($user->object());

        $I->sendPost('/api/ratings', [
          'bookmark' => '/api/bookmarks/1',
          'value' => 6,
        ]);

        $I->sendPatch('/api/ratings/1', ['value' => 10]);

        $I->expect(10 == $bookmark->getRateAverage());
    }

    public function putRatingUpdatesBookmarkRate(ApiTester $I)
    {
        $bookmark = BookmarkFactory::createOne();
        $user = UserFactory::createOne(['login' => 'user1', 'password' => 'test']);
        $I->amLoggedInAs($user->object());

        $I->sendPut('/api/ratings', [
          'bookmark' => '/api/bookmarks/1',
          'value' => 6,
        ]);

        $I->expect(6 == $bookmark->getRateAverage());
    }

    public function deleteRatingUpdatesBookmarkRate(ApiTester $I)
    {
        $bookmark = BookmarkFactory::createOne();
        
        $user = UserFactory::createOne(['login' => 'user1', 'password' => 'test']);
        $I->amLoggedInAs($user->object());

        RatingFactory::createOne(['user' => $user, 'bookmark' => $bookmark, 'value' => 10]);
        RatingFactory::createOne(['bookmark' => $bookmark, 'value' => 0]);

        $I->sendDelete('/api/ratings/2');

        $I->expect(10 == $bookmark->getRateAverage());
    }

    public function deleteAllRatingResetBookmarkRate(ApiTester $I)
    {
        $bookmark = BookmarkFactory::createOne();
        $user = UserFactory::createOne(['login' => 'user1', 'password' => 'test']);
        $I->amLoggedInAs($user->object());

        RatingFactory::createOne(['user' => $user, 'bookmark' => $bookmark, 'value' => 10]);
        RatingFactory::createOne(['bookmark' => $bookmark, 'value' => 0]);


        $I->sendDelete('/api/ratings/1');
        $I->sendDelete('/api/ratings/2');

        $I->expect(0 == $bookmark->getRateAverage());
    }
}
