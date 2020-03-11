<?php

namespace App\Entity;

use Cake\Chronos\Chronos;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShiftRepository")
 */
class Shift implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rota", inversedBy="shifts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rota;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Staff")
     * @ORM\JoinColumn(nullable=false)
     */
    private $staff;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endTime;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ShiftBreak", mappedBy="shift", orphanRemoval=true)
     */
    private $shiftBreaks;

    public static function getRepository(EntityManagerInterface $entityManager)
    {
        return $entityManager->getRepository(__CLASS__);
    }

    public function __construct()
    {
        $this->shiftBreaks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRota(): ?Rota
    {
        return $this->rota;
    }

    public function setRota(?Rota $rota): self
    {
        $this->rota = $rota;

        return $this;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return Collection|ShiftBreak[]
     */
    public function getShiftBreaks(): Collection
    {
        return $this->shiftBreaks;
    }

    public function addShiftBreak(ShiftBreak $shiftBreak): self
    {
        if (!$this->shiftBreaks->contains($shiftBreak)) {
            $this->shiftBreaks[] = $shiftBreak;
            $shiftBreak->setShift($this);
        }

        return $this;
    }

    public function removeShiftBreak(ShiftBreak $shiftBreak): self
    {
        if ($this->shiftBreaks->contains($shiftBreak)) {
            $this->shiftBreaks->removeElement($shiftBreak);
            // set the owning side to null (unless already changed)
            if ($shiftBreak->getShift() === $this) {
                $shiftBreak->setShift(null);
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
            'staff' => $this->getStaff(),
            'startDateTime' => Chronos::instance($this->getStartTime())->toIso8601String(),
            'endDateTime' => Chronos::instance($this->getEndTime())->toIso8601String(),
        ];
    }
}
