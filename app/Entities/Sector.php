<?php


namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

/** @ORM\Entity */
class Sector
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary_ordered_time", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator")
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="uuid_binary_ordered_time", nullable=true)
     */
    private UuidInterface $parentId;

    /**
     * @ORM\ManyToOne(targetEntity="Sector", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private Sector $parent;

    /**
     * @ORM\OneToMany(targetEntity="Sector", mappedBy="parent")
     */
    private ArrayCollection $children;

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

    public function getParent(): Sector
    {
        return $this->parent;
    }

    public function getParentId(): ?UuidInterface
    {
        return $this->parentId;
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