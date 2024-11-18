<?php

namespace App\Entity;

use App\Repository\CoachingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoachingRepository::class)
 */
class Coaching extends EntityBase implements CoachingInterface
{
    /**
     * @ORM\Column(type="integer")
     */
    private $rotation;

    /**
     * @ORM\OneToOne(targetEntity=Room::class, inversedBy="coaching", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $room;

    /**
     * @ORM\ManyToMany(targetEntity=People::class, inversedBy="coachings")
     */
    private $peoples;

    public function __construct()
    {
        $this->peoples = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getRotation(): ?int
    {
        return $this->rotation;
    }

    /**
     * @param int $rotation
     * @return $this
     */
    public function setRotation(int $rotation): self
    {
        $this->rotation = $rotation;

        return $this;
    }

    /**
     * @return Room|null
     */
    public function getRoom(): ?Room
    {
        return $this->room;
    }

    /**
     * @param Room $room
     * @return $this
     */
    public function setRoom(Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    /**
     * @return Collection<People>
     */
    public function getPeoples(): Collection
    {
        return $this->peoples;
    }

    /**
     * @param People $people
     * @return $this
     */
    public function addPeople(People $people): self
    {
        if (!$this->peoples->contains($people)) {
            $this->peoples[] = $people;
        }

        return $this;
    }

    /**
     * @param People $people
     * @return $this
     */
    public function removePeople(People $people): self
    {
        $this->peoples->removeElement($people);

        return $this;
    }

    /**
     * @return array
     */
    public function getArrayBaseEntity(): array
    {
        return array(
            'id' => $this->getId(),
            'rotation' => $this->getRotation(),
        );
    }

    /**
     * @return array
     */
    public function getArrayEntity(): array
    {
        $arr = $this->getArrayBaseEntity();
        $arrPeoples = array();

        /** @var People $people */
        foreach ($this->getPeoples() as $people) {
            $arrPeoples[] = $people->getArrayEntity();
        }

        $arr['peoples'] = $arrPeoples;
        $arr['room'] = $this->getRoom() instanceof RoomInterface ? $this->getRoom()->getArrayBaseEntity() : array();

        return $arr;
    }
}
