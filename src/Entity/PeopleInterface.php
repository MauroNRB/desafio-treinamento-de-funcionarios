<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface PeopleInterface extends EntityBaseInterface
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
     * @return Collection<Coaching>
     */
    public function getCoachings(): Collection;

    /**
     * @param Coaching $coaching
     */
    public function addCoaching(Coaching $coaching);

    /**
     * @param Coaching $coaching
     */
    public function removeCoaching(Coaching $coaching);

    /**
     * @return Cafeteria|null
     */
    public function getCafeteria(): ?Cafeteria;

    /**
     * @param Cafeteria|null $cafeteria
     */
    public function setCafeteria(?Cafeteria $cafeteria);
}