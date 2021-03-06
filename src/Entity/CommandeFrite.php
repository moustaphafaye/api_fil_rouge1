<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeFriteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeFriteRepository::class)]
#[ApiResource]
class CommandeFrite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["commander"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["commander"])]
    #[Assert\Positive(message:"la quantite doit étre superieure à 0")]
    #[Assert\NotBlank(message:"la quantité est obligatoire")]
    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandefrite')]
    private $commande;

    #[Groups(["commander"])]
    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'commandefrite')]
    private $portionFrite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getPortionFrite(): ?PortionFrite
    {
        return $this->portionFrite;
    }

    public function setPortionFrite(?PortionFrite $portionFrite): self
    {
        $this->portionFrite = $portionFrite;

        return $this;
    }
}
