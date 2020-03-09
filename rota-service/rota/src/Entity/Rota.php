<?php

namespace App\Entity;

use Cake\Chronos\Chronos;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RotaRepository")
 */
class Rota implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Shop")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shop;

    /**
     * @ORM\Column(type="date")
     */
    private $weekCommenceDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shift", mappedBy="rota", orphanRemoval=true)
     */
    private $shifts;

    public function __construct()
    {
        $this->shifts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getWeekCommenceDate(): ?\DateTimeInterface
    {
        return $this->weekCommenceDate;
    }

    public function setWeekCommenceDate(\DateTimeInterface $weekCommenceDate): self
    {
        $this->weekCommenceDate = $weekCommenceDate;

        return $this;
    }

    /**
     * @return Collection|Shift[]
     */
    public function getShifts(): Collection
    {
        return $this->shifts;
    }

    public function addShift(Shift $shift): self
    {
        if (!$this->shifts->contains($shift)) {
            $this->shifts[] = $shift;
            $shift->setRota($this);
        }

        return $this;
    }

    public function removeShift(Shift $shift): self
    {
        if ($this->shifts->contains($shift)) {
            $this->shifts->removeElement($shift);
            // set the owning side to null (unless already changed)
            if ($shift->getRota() === $this) {
                $shift->setRota(null);
            }
        }

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'shop' =>
                [
                    'id' => $this->getShop()->getId(),
                    'name' => $this->getShop()->getName()
                ],
            'weekCommence' => Chronos::instance($this->getWeekCommenceDate())->toDateString()
        ];
    }
}
