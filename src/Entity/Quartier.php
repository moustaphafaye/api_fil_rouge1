<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource(collectionOperations:["get",
            "post"=>[
                'status' => Response::HTTP_CREATED,
                'denormalization_context' => ['groups' => ['add:quartier']]]],
                itemOperations:["put","get"])]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["add:zone","commander"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["add:quartier"])]
    private $libelle;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartier')]
    private $zone;

    #[ORM\OneToMany(mappedBy: 'quartier', targetEntity: Commande::class)]
    private $commande;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande[] = $commande;
            $commande->setQuartier($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getQuartier() === $this) {
                $commande->setQuartier(null);
            }
        }

        return $this;
    }
}
