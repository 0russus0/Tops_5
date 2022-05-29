<?php

namespace App\Entity;

use App\Repository\TopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TopRepository::class)]
#[ORM\Table(name: "`tops`")]
#[ORM\HasLifecycleCallbacks]
class Top
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $uuid;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(min: 2, max: 50)]
    private string $title;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tops')]
    #[ORM\JoinColumn(nullable: false)]
    private User $author;

    #[ORM\Column(type: 'string', length: 255)]
    private string $icon;

    #[ORM\Column(type: 'integer')]
    private int $color;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'boolean')]
    private bool $collaborative;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private \DateTimeImmutable $deadline;

    /**
     * @var Collection<TopElement>
     */
    #[ORM\OneToMany(mappedBy: 'top', targetEntity: TopElement::class, orphanRemoval: true)]
    private Collection $topElements;

    /**
     * @var Collection<Vote>
     */
    #[ORM\OneToMany(mappedBy: 'top', targetEntity: Vote::class)]
    private Collection $votes;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->topElements = new ArrayCollection();
        $this->votes = new ArrayCollection();
        try {
            $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
            $this->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        } catch (\Exception $e) {
        }
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        try {
            $this->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        } catch (\Exception $e) {
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getColor(): ?int
    {
        return $this->color;
    }

    public function setColor(int $color): self
    {
        $this->color = $color;

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

    public function getCollaborative(): ?bool
    {
        return $this->collaborative;
    }

    public function setCollaborative(bool $collaborative): self
    {
        $this->collaborative = $collaborative;

        return $this;
    }

    public function getDeadline(): ?\DateTimeImmutable
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeImmutable $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * @return Collection<int, TopElement>
     */
    public function getTopElements(): Collection
    {
        return $this->topElements;
    }

    public function addTopElement(TopElement $topElement): self
    {
        if (!$this->topElements->contains($topElement)) {
            $this->topElements[] = $topElement;
            $topElement->setTop($this);
        }

        return $this;
    }

    public function removeTopElement(TopElement $topElement): self
    {
        if ($this->topElements->removeElement($topElement)) {
            // set the owning side to null (unless already changed)
            if ($topElement->getTop() === $this) {
                $topElement->setTop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setTop($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getTop() === $this) {
                $vote->setTop(null);
            }
        }

        return $this;
    }
}
