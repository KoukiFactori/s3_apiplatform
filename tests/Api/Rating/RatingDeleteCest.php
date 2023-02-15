<?php

namespace App\Tests\Api\Rating;

use App\Entity\Rating;
use App\Factory\BookmarkFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class RatingDeleteCest
{
  public function deleteRatingAnonymous(ApiTester $I)
  {
    $bookmark = BookmarkFactory::createOne();
    $user = UserFactory::createOne();

    RatingFactory::createOne([
      'user' => $user,
      'bookmark' => $bookmark
    ]);

    $I->sendDelete('/api/ratings/1');

    $I->seeResponseCodeIs(401);
  }

  public function deleteRatingNotOwning(ApiTester $I)
  {
    RatingFactory::createOne();

    $user = UserFactory::createOne(['login' => 'user1'])->object();
    $I->amLoggedInAs($user);

    $I->sendDelete('/api/ratings/1');

    $I->seeResponseCodeIs(403);
  }

  public function putRatingOwning(ApiTester $I)
  {
    $bookmark = BookmarkFactory::createOne();

    $user = UserFactory::createOne(['login' => 'user1'])->object();
    $I->amLoggedInAs($user);

    RatingFactory::createOne([
      'user' => $user,
      'bookmark' => $bookmark
    ]);

    $I->sendDelete('/api/ratings/1');

    $I->seeResponseCodeIs(204);
  }
}
