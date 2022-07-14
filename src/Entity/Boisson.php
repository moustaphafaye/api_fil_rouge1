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

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boisson')]
    private $menus;

    

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: TailleBoisson::class,cascade:["persist"])]
    #[Groups(["add:boisson"])]
    private $tailleboisson;

    public function __construct()
    {
        
        $this->menus = new ArrayCollection();
        
        $this->tailleboisson = new ArrayCollection();
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

    

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleboisson(): Collection
    {
        return $this->tailleboisson;
    }

    public function addTailleboisson(TailleBoisson $tailleboisson): self
    {
        if (!$this->tailleboisson->contains($tailleboisson)) {
            $this->tailleboisson[] = $tailleboisson;
            $tailleboisson->setBoisson($this);
        }

        return $this;
    }

    public function removeTailleboisson(TailleBoisson $tailleboisson): self
    {
        if ($this->tailleboisson->removeElement($tailleboisson)) {
            // set the owning side to null (unless already changed)
            if ($tailleboisson->getBoisson() === $this) {
                $tailleboisson->setBoisson(null);
            }
        }

        return $this;
    }
}
