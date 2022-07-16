<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource]
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["commander"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["add:boisson"])]
    #[ORM\Column(type: 'integer')]
    private $quantitetailleboissonstock;

    #[Groups(["add:boisson"])]
    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'tailleboisson')]
    private $boisson;

    #[Groups(["add:boisson","commander:detail"])]
    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'tailleboisson')]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'tailleBoisson', targetEntity: CommandeTailleBoisson::class)]
    private $commandetailleboisson;

    public function __construct()
    {
        $this->commandetailleboisson = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id):self
    {
        $this->id=$id;
        return $this;
    }
    public function getQquantitetailleboissonstock(): ?int
    {
        return $this->quantitetailleboissonstock;
    }

    public function setQuantitetailleboissonstock(int $quantitetailleboissonstock): self
    {
        $this->quantitetailleboissonstock = $quantitetailleboissonstock;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * @return Collection<int, CommandeTailleBoisson>
     */
    public function getCommandetailleboisson(): Collection
    {
        return $this->commandetailleboisson;
    }

    public function addCommandetailleboisson(CommandeTailleBoisson $commandetailleboisson): self
    {
        if (!$this->commandetailleboisson->contains($commandetailleboisson)) {
            $this->commandetailleboisson[] = $commandetailleboisson;
            $commandetailleboisson->setTailleBoisson($this);
        }

        return $this;
    }

    public function removeCommandetailleboisson(CommandeTailleBoisson $commandetailleboisson): self
    {
        if ($this->commandetailleboisson->removeElement($commandetailleboisson)) {
            // set the owning side to null (unless already changed)
            if ($commandetailleboisson->getTailleBoisson() === $this) {
                $commandetailleboisson->setTailleBoisson(null);
            }
        }

        return $this;
    }
}
