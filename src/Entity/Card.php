<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cardName;

    /**
     * @ORM\Column(type="integer")
     */
    private $lifePoints;

    /**
     * @ORM\Column(type="integer")
     */
    private $attackPoints;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Faction", inversedBy="cards")
     * @ORM\JoinColumn(nullable=true)
     */
    private $faction;

    /**
     * @ORM\Column(type="integer")
     */
    private $manaCost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="cards")
     */
    private $creator;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deckcard", mappedBy="card", orphanRemoval=true)
     */
    private $deckcards;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Passive", inversedBy="cards")
     */
    private $passive;

    public function __construct()
    {
        $this->deckcards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardName(): ?string
    {
        return $this->cardName;
    }

    public function setCardName(string $cardName): self
    {
        $this->cardName = $cardName;

        return $this;
    }

    public function getLifePoints(): ?int
    {
        return $this->lifePoints;
    }

    public function setLifePoints(int $lifePoints): self
    {
        $this->lifePoints = $lifePoints;

        return $this;
    }

    public function getAttackPoints(): ?int
    {
        return $this->attackPoints;
    }

    public function setAttackPoints(int $attackPoints): self
    {
        $this->attackPoints = $attackPoints;

        return $this;
    }

    public function getFaction(): ?Faction
    {
        return $this->faction;
    }

    public function setFaction(?Faction $faction): self
    {
        $this->faction = $faction;

        return $this;
    }

    public function getManaCost(): ?int
    {
        return $this->manaCost;
    }

    public function setManaCost(int $manaCost): self
    {
        $this->manaCost = $manaCost;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Deckcard[]
     */
    public function getDeckcards(): Collection
    {
        return $this->deckcards;
    }

    public function addDeckcard(Deckcard $deckcard): self
    {
        if (!$this->deckcards->contains($deckcard)) {
            $this->deckcards[] = $deckcard;
            $deckcard->setCard($this);
        }

        return $this;
    }

    public function removeDeckcard(Deckcard $deckcard): self
    {
        if ($this->deckcards->contains($deckcard)) {
            $this->deckcards->removeElement($deckcard);
            // set the owning side to null (unless already changed)
            if ($deckcard->getCard() === $this) {
                $deckcard->setCard(null);
            }
        }

        return $this;
    }

    public function getPassive(): ?Passive
    {
        return $this->passive;
    }

    public function setPassive(?Passive $passive): self
    {
        $this->passive = $passive;

        return $this;
    }
}
