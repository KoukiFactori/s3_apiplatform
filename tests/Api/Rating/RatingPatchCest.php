<?php

namespace App\Tests\Api\Rating;

use App\Entity\Bookmark;
use App\Factory\BookmarkFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class RatingPatchCest
{
  public function patchRatingAnonymous(ApiTester $I)
  {
    $bookmark = BookmarkFactory::createOne();
    $user = UserFactory::createOne();

    RatingFactory::createOne([
      'user' => $user,
      'bookmark' => $bookmark
    ]);

    $I->sendPatch('/api/ratings/1', [
      'value' => 3
    ]);

    $I->seeResponseCodeIs(401);
  }

  public function patchRatingNotOwning(ApiTester $I)
  {
    $bookmark = BookmarkFactory::createOne();
    $owner = UserFactory::createOne();

    RatingFactory::createOne([
      'user' => $owner,
      'bookmark' => $bookmark
    ]);

    $user = UserFactory::createOne(['login' => 'user1'])->object();
    $I->amLoggedInAs($user);

    $I->sendPatch('/api/ratings/' . $bookmark->getId(), [
      'value' => 3
    ]);

    $I->seeResponseCodeIs(403);
  }

  public function patchRatingOwning(ApiTester $I)
  {
    $bookmark = BookmarkFactory::createOne();

    $user = UserFactory::createOne(['login' => 'user1'])->object();
    $I->amLoggedInAs($user);

    RatingFactory::createOne([
      'user' => $user,
      'bookmark' => $bookmark
    ]);

    $I->sendPatch('/api/ratings/' . $bookmark->getId(), [
      'value' => 3
    ]);

    $I->seeResponseCodeIs(200);
  }
}
