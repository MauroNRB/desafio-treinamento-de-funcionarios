<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface CoachingInterface extends EntityBaseInterface
{
    /**
     * @return int|null
     */
    public function getRotation(): ?int;

    /**
     * @param int $rotation
     */
    public function setRotation(int $rotation);

    /**
     * @return Collection<People>
     */
    public function getPeoples(): Collection;

    /**
     * @param People $people
     */
    public function addPeople(People $people);

    /**
     * @param People $people
     */
    public function removePeople(People $people);

    /**
     * @return Room|null
     */
    public function getRoom(): ?Room;

    /**
     * @param Room $room
     */
    public function setRoom(Room $room);
}