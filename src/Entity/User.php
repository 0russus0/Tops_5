<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "`users`")]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    /** @var string[] $roles */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $userName = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $avatar;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $googleId;

    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $uuid;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Ban::class, cascade: ['persist', 'remove'])]
    private Ban $ban;

    #[ORM\OneToMany(mappedBy: 'following', targetEntity: FollowUser::class)]
    private FollowUser $followings;

    #[ORM\OneToMany(mappedBy: 'follower', targetEntity: FollowUser::class)]
    private FollowUser $followers;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Top::class, orphanRemoval: true)]
    private Top $tops;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Vote::class)]
    private Vote $votes;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Category::class)]
    private Category $categories;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: FollowCategory::class, orphanRemoval: true)]
    private FollowCategory $followCategories;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: CategoryRequest::class)]
    private CategoryRequest $categoryRequests;


    public function __construct()
    {
        $this->followings = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->tops = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->followCategories = new ArrayCollection();
        $this->categoryRequests = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

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

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(?string $googleId): self
    {
        $this->googleId = $googleId;

        return $this;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getBan(): ?Ban
    {
        return $this->ban;
    }

    public function setBan(Ban $ban): self
    {
        // set the owning side of the relation if necessary
        if ($ban->getUser() !== $this) {
            $ban->setUser($this);
        }

        $this->ban = $ban;

        return $this;
    }

    /**
     * @return Collection<int, FollowUser>
     */
    public function getFollowings(): Collection
    {
        return $this->followings;
    }

    public function addFollowing(FollowUser $following): self
    {
        if (!$this->followings->contains($following)) {
            $this->followings[] = $following;
            $following->setFollowing($this);
        }

        return $this;
    }

    public function removeFollowing(FollowUser $following): self
    {
        if ($this->followings->removeElement($following)) {
            // set the owning side to null (unless already changed)
            if ($following->getFollowing() === $this) {
                $following->setFollowing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FollowUser>
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(FollowUser $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
            $follower->setFollower($this);
        }

        return $this;
    }

    public function removeFollower(FollowUser $follower): self
    {
        if ($this->followers->removeElement($follower)) {
            // set the owning side to null (unless already changed)
            if ($follower->getFollower() === $this) {
                $follower->setFollower(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Top>
     */
    public function getTops(): Collection
    {
        return $this->tops;
    }

    public function addTop(Top $top): self
    {
        if (!$this->tops->contains($top)) {
            $this->tops[] = $top;
            $top->setAuthor($this);
        }

        return $this;
    }

    public function removeTop(Top $top): self
    {
        if ($this->tops->removeElement($top)) {
            // set the owning side to null (unless already changed)
            if ($top->getAuthor() === $this) {
                $top->setAuthor(null);
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
            $vote->setAuthor($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getAuthor() === $this) {
                $vote->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setAuthor($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getAuthor() === $this) {
                $category->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FollowCategory>
     */
    public function getFollowCategories(): Collection
    {
        return $this->followCategories;
    }

    public function addFollowCategory(FollowCategory $followCategory): self
    {
        if (!$this->followCategories->contains($followCategory)) {
            $this->followCategories[] = $followCategory;
            $followCategory->setUser($this);
        }

        return $this;
    }

    public function removeFollowCategory(FollowCategory $followCategory): self
    {
        if ($this->followCategories->removeElement($followCategory)) {
            // set the owning side to null (unless already changed)
            if ($followCategory->getUser() === $this) {
                $followCategory->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategoryRequest>
     */
    public function getCategoryRequests(): Collection
    {
        return $this->categoryRequests;
    }

    public function addCategoryRequest(CategoryRequest $categoryRequest): self
    {
        if (!$this->categoryRequests->contains($categoryRequest)) {
            $this->categoryRequests[] = $categoryRequest;
            $categoryRequest->setAuthor($this);
        }

        return $this;
    }

    public function removeCategoryRequest(CategoryRequest $categoryRequest): self
    {
        if ($this->categoryRequests->removeElement($categoryRequest)) {
            // set the owning side to null (unless already changed)
            if ($categoryRequest->getAuthor() === $this) {
                $categoryRequest->setAuthor(null);
            }
        }

        return $this;
    }
}
