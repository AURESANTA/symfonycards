<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeckRepository")
 */
class Deck
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
    private $deckname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deckcard", mappedBy="deck")
     */
    private $deckcards;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="decks")
     */
    private $creator;

    public function __construct()
    {
        $this->deckcards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeckname(): ?string
    {
        return $this->deckname;
    }

    public function setDeckname(string $deckname): self
    {
        $this->deckname = $deckname;

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
            $deckcard->setDeck($this);
        }

        return $this;
    }

    public function removeDeckcard(Deckcard $deckcard): self
    {
        if ($this->deckcards->contains($deckcard)) {
            $this->deckcards->removeElement($deckcard);
            // set the owning side to null (unless already changed)
            if ($deckcard->getDeck() === $this) {
                $deckcard->setDeck(null);
            }
        }

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
}
