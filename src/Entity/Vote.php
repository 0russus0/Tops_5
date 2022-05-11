<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
#[ORM\Table(name: "`votes`")]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private User $author;

    #[ORM\ManyToOne(targetEntity: Top::class, inversedBy: 'votes')]
    private Top $top;

    #[ORM\ManyToOne(targetEntity: TopElement::class, inversedBy: 'votes')]
    private TopElement $topElement;


    #[ORM\Column(type: 'integer')]
    private int $type;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\ManyToOne(targetEntity: CategoryRequest::class, inversedBy: 'votes')]
    private CategoryRequest $categoryRequest;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTop(): ?Top
    {
        return $this->top;
    }

    public function setTop(?Top $top): self
    {
        $this->top = $top;

        return $this;
    }

    public function getTopElement(): ?TopElement
    {
        return $this->topElement;
    }

    public function setTopElement(?TopElement $topElement): self
    {
        $this->topElement = $topElement;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategoryRequest(): ?CategoryRequest
    {
        return $this->categoryRequest;
    }

    public function setCategoryRequest(?CategoryRequest $categoryRequest): self
    {
        $this->categoryRequest = $categoryRequest;

        return $this;
    }
}
