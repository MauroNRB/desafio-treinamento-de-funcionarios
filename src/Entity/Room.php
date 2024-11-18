<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room extends EntityBase implements RoomInterface
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\OneToOne(targetEntity=Coaching::class, mappedBy="room", cascade={"persist", "remove"})
     */
    private $coaching;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    /**
     * @param int $capacity
     * @return $this
     */
    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Coaching|null
     */
    public function getCoaching(): ?Coaching
    {
        return $this->coaching;
    }

    /**
     * @param Coaching $coaching
     * @return $this
     */
    public function setCoaching(Coaching $coaching): self
    {
        // set the owning side of the relation if necessary
        if ($coaching->getRoom() !== $this) {
            $coaching->setRoom($this);
        }

        $this->coaching = $coaching;

        return $this;
    }

    /**
     * @return array
     */
    public function getArrayBaseEntity(): array
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'capacity' => $this->getCapacity(),
        );
    }

    /**
     * @return array
     */
    public function getArrayEntity(): array
    {
        $arr = $this->getArrayBaseEntity();
        $arr['coaching'] = $this->getCoaching() instanceof CoachingInterface ? $this->getCoaching()->getArrayBaseEntity() : array();

        return $arr;
    }
}
