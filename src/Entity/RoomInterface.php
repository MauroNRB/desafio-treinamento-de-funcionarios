<?php

namespace App\Entity;

interface RoomInterface extends EntityBaseInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $name
     */
    public function setName(string $name);

    /**
     * @return int|null
     */
    public function getCapacity(): ?int;

    /**
     * @param int $capacity
     */
    public function setCapacity(int $capacity);

    /**
     * @return Coaching|null
     */
    public function getCoaching(): ?Coaching;

    /**
     * @param Coaching $coaching
     */
    public function setCoaching(Coaching $coaching);
}