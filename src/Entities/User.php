<?php


namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary_ordered_time", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator")
     *
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"create_user"})
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"create_user"})
     */
    private string $lastName;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups({"create_user"})
     */
    private bool $hasAgreedToTerms = false;

    /**
     * @ORM\ManyToMany(targetEntity="Sector")
     * @ORM\JoinTable(name="user_sector",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="sector_id", referencedColumnName="id")}
     *     )
     *
     * @Groups({"create_user"})
     */
    private Collection $sectors;

    public function __construct()
    {
        $this->sectors = new ArrayCollection();
    }

    /**
     * @return UuidInterface
     *
     * @Groups({"create_user"})
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getSectors(): Collection
    {
        return $this->sectors;
    }

    public function hasAgreedToTerms(): bool
    {
        return $this->hasAgreedToTerms;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function addSector(Sector $sector)
    {
        $this->sectors->add($sector);
    }

    public function agreeToTerms()
    {
        $this->hasAgreedToTerms = true;
    }

}