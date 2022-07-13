<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\DataPersist\Persist;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(collectionOperations:[
    "get"=>[
        'method' => 'get',
        // 'path'=>'/listerMenu',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['menu:list']],
        ],
   "post"=> [
    'status' => Response::HTTP_CREATED,
    'denormalization_context' => ['groups' => ['ajouter:menu']],
    'normalization_context' => ['groups' => ['menu:all']],
    "security" => "is_granted('ROLE_GESTIONNAIRE')",
    "security_message"=>"Vous n'avez pas access à cette Ressource"
    ]],
    itemOperations:["put"=>[
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
        'denormalization_context' => ['groups' => ['modifier:menu']]
                ],
        "get"=>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['menu:simple']],
            ]])]
class Menu extends Produit
{
    // #[Groups(["ajouter:menu","menu:simple","menu:all","menu:list"])]
    // #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Burger::class)]
    // private $burger;

    // #[Groups(["menu:list","modifier:menu","menu:simple"])]
    // #[ORM\ManyToMany(targetEntity: PortionFrite::class, inversedBy: 'menus')]
    // private $portionfrites;

    // #[Groups(["menu:list","ajouter:menu","modifier:menu","menu:simple"])]
    // #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'menus')]
    // private $boisson;

    // #[Groups(["ajouter:menu"])]
    // #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menu')]
    // private $gestionnaire;

    // #[Groups(["ajouter:menu","menu:simple","menu:all","menu:list"])]
    // #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    // private $burger;

    //  #[Groups(["menu:list","ajouter:menu"])]
    //  #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'menus')]
    //  private $taille;

    

     #[Groups(["ajouter:menu"])]
     #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class,cascade:["persist","remove"])]
     private $menutaille;

    #[Assert\Valid()]
    #[Assert\NotBlank] 
    #[Assert\Count(
        min: 1,
        minMessage: 'le menu doit avoir au moins 1 burber')] 
    #[Groups(["ajouter:menu"])]
     #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:["persist"])]
     private $menuburger;

     #[Groups(["ajouter:menu"])]
     #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuPortionFrite::class,cascade:["persist"])]
     private $menuportionfriet;

    

    public function __construct()
    {
        
        // $this->portionfrites = new ArrayCollection();
        $this->taille = new ArrayCollection();
       
        $this->menutaille = new ArrayCollection();
        $this->menuburger = new ArrayCollection();
        $this->menuportionfriet = new ArrayCollection();
       
        
    }
    // /**
    //  * @return Collection<int, PortionFrite>
    //  */
    // public function getPortionfrites(): Collection
    // {
    //     return $this->portionfrites;
    // }

    // public function addPortionfrite(PortionFrite $portionfrite): self
    // {
    //     if (!$this->portionfrites->contains($portionfrite)) {
    //         $this->portionfrites[] = $portionfrite;
    //     }

    //     return $this;
    // }

    // public function removePortionfrite(PortionFrite $portionfrite): self
    // {
    //     $this->portionfrites->removeElement($portionfrite);

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
            $menutaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenutaille(MenuTaille $menutaille): self
    {
        if ($this->menutaille->removeElement($menutaille)) {
            // set the owning side to null (unless already changed)
            if ($menutaille->getMenu() === $this) {
                $menutaille->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuburger(): Collection
    {
        return $this->menuburger;
    }

    public function addMenuburger(MenuBurger $menuburger): self
    {
        if (!$this->menuburger->contains($menuburger)) {
            $this->menuburger[] = $menuburger;
            $menuburger->setMenu($this);
        }

        return $this; 
    }

    public function removeMenuburger(MenuBurger $menuburger): self
    {
        if ($this->menuburger->removeElement($menuburger)) {
            // set the owning side to null (unless already changed)
            if ($menuburger->getMenu() === $this) {
                $menuburger->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuPortionFrite>
     */
    public function getMenuportionfriet(): Collection
    {
        return $this->menuportionfriet;
    }

    public function addMenuportionfriet(MenuPortionFrite $menuportionfriet): self
    {
        if (!$this->menuportionfriet->contains($menuportionfriet)) {
            $this->menuportionfriet[] = $menuportionfriet;
            $menuportionfriet->setMenu($this);
        }

        return $this;
    }

    public function removeMenuportionfriet(MenuPortionFrite $menuportionfriet): self
    {
        if ($this->menuportionfriet->removeElement($menuportionfriet)) {
            // set the owning side to null (unless already changed)
            if ($menuportionfriet->getMenu() === $this) {
                $menuportionfriet->setMenu(null);
            }
        }

        return $this;
    }

    
    

    
    
   
}
