<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeBurgerRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeBurgerRepository::class)]
#[ApiResource]
class CommandeBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    // #[Groups(["commander"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\Positive(message:"la nombre de burger doit étre superieure à 0")]
    #[Assert\NotBlank(message:"la quantité est obligatoire")]
    #[Groups(["commander"])]
    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeburger')]
    private $commande;

    #[Groups(["commander"])]
    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'commandeburger')]
    private $burger;

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

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }
}
