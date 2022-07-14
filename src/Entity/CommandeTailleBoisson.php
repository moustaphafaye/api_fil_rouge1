<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeTailleBoissonRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeTailleBoissonRepository::class)]
#[ApiResource]
class CommandeTailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["commander"])]
    #[ORM\Column(type: 'integer')]
    private $quantitetailleboisson;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandetailleboisson')]
    private $commande;

    #[Groups(["commander"])]
    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'commandetailleboisson')]
    private $tailleBoisson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantitetailleboisson(): ?int
    {
        return $this->quantitetailleboisson;
    }

    public function setQuantitetailleboisson(int $quantitetailleboisson): self
    {
        $this->quantitetailleboisson = $quantitetailleboisson;

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

    public function getTailleBoisson(): ?TailleBoisson
    {
        return $this->tailleBoisson;
    }

    public function setTailleBoisson(?TailleBoisson $tailleBoisson): self
    {
        $this->tailleBoisson = $tailleBoisson;

        return $this;
    }
}
