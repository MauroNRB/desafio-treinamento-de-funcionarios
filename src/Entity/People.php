<?php

namespace App\Entity;

use App\Repository\PeopleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PeopleRepository::class)
 */
class People extends EntityBase implements PeopleInterface
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\ManyToMany(targetEntity=Coaching::class, mappedBy="peoples")
     */
    private $coachings;

    /**
     * @ORM\ManyToOne(targetEntity=Cafeteria::class, inversedBy="peoples")
     */
    private $cafeteria;

    public function __construct()
    {
        $this->coachings = new ArrayCollection();
    }

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
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->getName() . ' ' . $this->getLastName();
    }

    /**
     * @return Collection<Coaching>
     */
    public function getCoachings(): Collection
    {
        return $this->coachings;
    }

    /**
     * @param Coaching $coaching
     * @return $this
     */
    public function addCoaching(Coaching $coaching): self
    {
        if (!$this->coachings->contains($coaching)) {
            $this->coachings[] = $coaching;
            $coaching->addPeople($this);
        }

        return $this;
    }

    /**
     * @param Coaching $coaching
     * @return $this
     */
    public function removeCoaching(Coaching $coaching): self
    {
        if ($this->coachings->removeElement($coaching)) {
            $coaching->removePeople($this);
        }

        return $this;
    }

    /**
     * @return Cafeteria|null
     */
    public function getCafeteria(): ?Cafeteria
    {
        return $this->cafeteria;
    }

    /**
     * @param Cafeteria|null $cafeteria
     * @return $this
     */
    public function setCafeteria(?Cafeteria $cafeteria): self
    {
        $this->cafeteria = $cafeteria;

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
            'lastName' => $this->getLastName(),
            'fullName' => $this->getFullName(),
        );
    }

    /**
     * @return array
     */
    public function getArrayEntity(): array
    {
        $arr = $this->getArrayBaseEntity();
        $arr['cafeteria'] = $this->getCafeteria() instanceof CafeteriaInterface ? $this->getCafeteria()->getArrayBaseEntity() : array();
        $arrCoachings = array();

        /** @var Coaching $coaching */
        foreach ($this->getCoachings() as $coaching) {
            $arrCoachings[] = $coaching->getArrayBaseEntity();
        }

        $arr['coachings'] = $arrCoachings;

        return $arr;
    }
}
