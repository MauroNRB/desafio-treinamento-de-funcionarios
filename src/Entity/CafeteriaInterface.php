<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface CafeteriaInterface extends EntityBaseInterface
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
}