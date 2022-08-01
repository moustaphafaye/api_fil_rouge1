<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
#[ApiResource]
class MenuBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["ajouter:menu","menu:simple","menu:list","detail"])]
    private $id;

     #[Groups(["ajouter:menu","menu:list","menu:simple"])] 
    #[Assert\NotBlank(message:"la quantité est obligatoire")]
    #[Assert\Positive(message:"la quantité doit étre superieure à 0")]
    #[ORM\Column(type: 'integer')]
    private $quentity;

    #[ApiSubresource]
    // #[Groups(["menu:of:burger"])]
    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuburger')]
    private $menu;

    #[Groups(["ajouter:menu","menu:list","menu:simple","detail"])]
    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuburger')]
    private $burger;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuentity(): ?int
    {
        return $this->quentity;
    }

    public function setQuentity(int $quentity): self
    {
        $this->quentity = $quentity;

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
