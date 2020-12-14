<?php


namespace App\Entities;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="sectors")
 */
class Sector
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary_ordered_time", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator")
     *
     * @Groups({"create_user", "update_user", "all_sectors"})
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"create_user", "update_user", "all_sectors"})
     */
    private string $name;

    /**
     * @ORM\Column(type="uuid_binary_ordered_time", nullable=true)
     *
     * @Groups({"all_sectors"})
     */
    private ?UuidInterface $parentId;

    /**
     * @ORM\ManyToOne(targetEntity="Sector", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private ?Sector $parent;

    /**
     * @ORM\OneToMany(targetEntity="Sector", mappedBy="parent")
     *
     * @Groups({"all_sectors"})
     */
    private Collection $children;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function hasParent(): bool
    {
        return $this->getParentId() !== null;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParent(): ?Sector
    {
        return $this->parent;
    }

    public function getParentId(): ?UuidInterface
    {
        return $this->parentId;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setParent(Sector $parent)
    {
        $this->parentId = $parent->getId();
        $this->parent = $parent;
    }
}