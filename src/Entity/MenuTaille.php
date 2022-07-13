<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuTailleRepository::class)]
#[ApiResource(collectionOperations:["get",
            "post"=>[
                'method' => 'post',
                        'status' => Response::HTTP_OK,
                        'denormalization_context' => ['groups' => ['ajouter:menutaille']],
                        // 'normalization_context' => ['groups' => ['menuburger']],
            ]],
            itemOperations:["put","get"])]
class MenuTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["ajouter:menu"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["ajouter:menutaille","ajouter:menu"])]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'menutaille')]
    #[Groups(["ajouter:menutaille","ajouter:menu"])]
    private $taille;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menutaille')]
    #[Groups(["ajouter:menutaille"])]
    private $menu;

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

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

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
}
