<?php

namespace App\Factory;

use App\Entity\Bookmark;
use App\Repository\BookmarkRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Bookmark>
 *
 * @method        Bookmark|Proxy create(array|callable $attributes = [])
 * @method static Bookmark|Proxy createOne(array $attributes = [])
 * @method static Bookmark|Proxy find(object|array|mixed $criteria)
 * @method static Bookmark|Proxy findOrCreate(array $attributes)
 * @method static Bookmark|Proxy first(string $sortedField = 'id')
 * @method static Bookmark|Proxy last(string $sortedField = 'id')
 * @method static Bookmark|Proxy random(array $attributes = [])
 * @method static Bookmark|Proxy randomOrCreate(array $attributes = [])
 * @method static BookmarkRepository|RepositoryProxy repository()
 * @method static Bookmark[]|Proxy[] all()
 * @method static Bookmark[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Bookmark[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Bookmark[]|Proxy[] findBy(array $attributes)
 * @method static Bookmark[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Bookmark[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class BookmarkFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->company(),
            'description' => self::faker()->paragraph(),
            'creationDate' => self::faker()->dateTimeBetween('-2 years'),
            'isPublic' => self::faker()->boolean(),
            'url' => self::faker()->url(),
            'rateAverage' => 0,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Bookmark $bookmark): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Bookmark::class;
    }
}
