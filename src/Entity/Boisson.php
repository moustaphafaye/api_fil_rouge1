<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations:["get"=>[
        'method' => 'get',
    'status' => Response::HTTP_OK,
    'normalization_context' => ['groups' => ['boisson:list']],],
                        "post"=>[
                            'status' => Response::HTTP_CREATED,
                            'denormalization_context' => ['groups' => ['add:boisson']],  
                            'normalization_context' => ['groups' => ['add:boisson:p']]  
                        ]],
    itemOperations:["put"=>[
        'method' => 'put',
        'status' => Response::HTTP_OK,
        'denormalization_context' => ['groups' => ['boisson:modifier']]
    ]
                        
    ,
                "get"=>[
                    'method' => 'get',
                    'status' => Response::HTTP_OK,
                    'normalization_context' => ['groups' => ['boisson:taille']],
                    ]]
)]
class  Boisson extends Produit   
{
    
    #[Groups(["add:boisson","boisson:list","boisson:taille","ajouter:menu","menu:list","boisson:modifier","menu:simple"])]
    #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'boissons')]
    private $taille;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boisson')]
    private $menus;

    public function __construct()
    {
        $this->taille = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getTaille(): Collection
    {
        return $this->taille;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->taille->contains($taille)) {
            $this->taille[] = $taille;
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        $this->taille->removeElement($taille);

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            // $menu->addBoisson($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // $menu->removeBoisson($this);
        }

        return $this;
    }
}
