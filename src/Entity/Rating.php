<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\RatingRepository;
use App\Validator\IsAuthenticatedUser;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
#[UniqueEntity(fields: ['user', 'bookmark'])]
#[ApiResource()]
#[Get()]
#[GetCollection()]
#[Post(
    security: 'is_granted("ROLE_USER")',
    securityMessage: 'You need a account to post rating',
)]
#[Patch(
    security: 'is_granted("ROLE_USER") and object.getUser() == user',
    securityMessage: 'Invalid account',
)]
#[Put(
    security: 'is_granted("ROLE_USER") and object.getUser() == user',
    securityMessage: 'Invalid account',
)]
#[Delete(
    security: 'is_granted("ROLE_USER") and object.getUser() == user',
    securityMessage: 'Invalid account',
)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[IsAuthenticatedUser()]
    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\Range(min: 0, max: 10, notInRangeMessage: 'Rating value must be between 0 and 10')]
    private ?int $value = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bookmark $bookmark = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getBookmark(): ?Bookmark
    {
        return $this->bookmark;
    }

    public function setBookmark(?Bookmark $bookmark): self
    {
        $this->bookmark = $bookmark;

        return $this;
    }
}
