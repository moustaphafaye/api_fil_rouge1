<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenuPortionFriteRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuPortionFriteRepository::class)]
#[ApiResource]
class MenuPortionFrite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["ajouter:menu"])]
     #[ORM\Column(type: 'integer')]
    private $id;

     #[Groups(["ajouter:menu"])]
     #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuportionfriet')]
    private $menu;

     #[Groups(["ajouter:menu"])]
     #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'menuprotionfrite')]
    private $portionFrite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

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
