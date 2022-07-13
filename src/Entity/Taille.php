<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    collectionOperations:["get"=>[
    'status' => Response::HTTP_CREATED,
    // 'denormalization_context' => ['groups' => ['add:taille']],  
    'normalization_context' => ['groups' => ['list:taile']]],
    "post"=>[
        'status' => Response::HTTP_CREATED,
        'denormalization_context' => ['groups' => ['add:taille']],  
        // 'normalization_context' => ['groups' => ['add:boisson:p']] 
    ]],

    itemOperations:["put","get"])]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["add:boisson","ajouter:menutaille","ajouter:menu","ajouter:menu","menu:list","boisson:modifier"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["add:taille","list:taile","add:boisson","boisson:list","boisson:taille","menu:simple"])]
    private $Prix;

    #[Groups(["add:taille","list:taile","add:boisson","boisson:list","boisson:taille","menu:simple"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $libelle;

    #[Groups(["add:taille","list:taile"])]
    #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'taille')]
    private $boissons;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenuTaille::class)]
    private $menutaille;

    // #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'taille')]
    // private $menus;

    public function __construct()
    {
        $this->boissons = new ArrayCollection();
        // $this->menus = new ArrayCollection();
        $this->menutaille = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(?int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
            $boisson->addTaille($this);
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        if ($this->boissons->removeElement($boisson)) {
            $boisson->removeTaille($this);
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Menu>
    //  */
    // public function getMenus(): Collection
    // {
    //     return $this->menus;
    // }

    // public function addMenu(Menu $menu): self
    // {
    //     if (!$this->menus->contains($menu)) {
    //         $this->menus[] = $menu;
    //         $menu->addTaille($this);
    //     }

    //     return $this;
    // }

    // public function removeMenu(Menu $menu): self
    // {
    //     if ($this->menus->removeElement($menu)) {
    //         $menu->removeTaille($this);
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenutaille(): Collection
    {
        return $this->menutaille;
    }

    public function addMenutaille(MenuTaille $menutaille): self
    {
        if (!$this->menutaille->contains($menutaille)) {
            $this->menutaille[] = $menutaille;
            $menutaille->setTaille($this);
        }

        return $this;
    }

    public function removeMenutaille(MenuTaille $menutaille): self
    {
        if ($this->menutaille->removeElement($menutaille)) {
            // set the owning side to null (unless already changed)
            if ($menutaille->getTaille() === $this) {
                $menutaille->setTaille(null);
            }
        }

        return $this;
    }
}
