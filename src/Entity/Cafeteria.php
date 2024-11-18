<?php

namespace App\Entity;

use App\Repository\CafeteriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CafeteriaRepository::class)
 */
class Cafeteria extends EntityBase implements CafeteriaInterface
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity=People::class, mappedBy="cafeteria")
     */
    protected $peoples;

    public function __construct()
    {
        $this->peoples = new ArrayCollection();
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
            $people->setCafeteria($this);
        }

        return $this;
    }

    /**
     * @param People $people
     * @return $this
     */
    public function removePeople(People $people): self
    {
        if ($this->peoples->removeElement($people)) {
            // set the owning side to null (unless already changed)
            if ($people->getCafeteria() === $this) {
                $people->setCafeteria(null);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getArrayBaseEntity(): array
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName()
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

        return $arr;
    }
}
