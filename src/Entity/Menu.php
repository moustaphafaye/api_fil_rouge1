<?php

namespace App\Entity;

use App\DataPersist\Persist;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
    'input_formats' => [
    'multipart' => ['multipart/form-data']],

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
    #[Groups(["ajouter:menu","menu:list","menu:simple","produit","detail"])]
     #[ApiSubresource]
     #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:["persist"])]
     private $menuburger;

     #[Groups(["ajouter:menu","menu:simple"])]
     #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuPortionFrite::class,cascade:["persist"])]
     private $menuportionfriet;

     #[ORM\OneToMany(mappedBy: 'menu', targetEntity: CommandeMenu::class)]
     private $commandemenu;

     



    //  #[ORM\OneToMany(mappedBy: 'menu', targetEntity: CommandeMenu::class)]
    //  private $commandemenu;

    

    public function __construct()
    {
        
        // $this->portionfrites = new ArrayCollection();
        $this->taille = new ArrayCollection();
       
        $this->menutaille = new ArrayCollection();
        $this->menuburger = new ArrayCollection();
        $this->menuportionfriet = new ArrayCollection();
        // $this->commandemenu = new ArrayCollection();
        $this->details = new ArrayCollection();
       
        
    }

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

    
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context)
    {
        // ...
        if (count($this->getMenuportionfriet())==0 && count($this->getMenutaille())==0) {
            
            $context->buildViolation('vous devez au moins ajouter un complement ')
                    ->addViolation();
        }

        for ($i=0; $i < count($this->getMenuburger()) ; $i++) {
            
            
            $ids[]= $this->getMenuburger()[$i]->getBurger()->getId();
            
        }
         if(array_unique($ids)!=$ids){
            $context->buildViolation('Vous avez une repetition de burger ')
                    ->addViolation();
         }

    }

    

    /**
     * @return Collection<int, CommandeMenu>
     */
    public function getCommandemenu(): Collection
    {
        return $this->commandemenu;
    }

    public function addCommandemenu(CommandeMenu $commandemenu): self
    {
        if (!$this->commandemenu->contains($commandemenu)) {
            $this->commandemenu[] = $commandemenu;
            $commandemenu->setMenu($this);
        }

        return $this;
    }

    public function removeCommandemenu(CommandeMenu $commandemenu): self
    {
        if ($this->commandemenu->removeElement($commandemenu)) {
            // set the owning side to null (unless already changed)
            if ($commandemenu->getMenu() === $this) {
                $commandemenu->setMenu(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Detail>
    //  */
    // public function getDetails(): Collection
    // {
    //     return $this->details;
    // }

    // public function addDetail(Detail $detail): self
    // {
    //     if (!$this->details->contains($detail)) {
    //         $this->details[] = $detail;
    //         $detail->setMenu($this);
    //     }

    //     return $this;
    // }

    // public function removeDetail(Detail $detail): self
    // {
    //     if ($this->details->removeElement($detail)) {
    //         // set the owning side to null (unless already changed)
    //         if ($detail->getMenu() === $this) {
    //             $detail->setMenu(null);
    //         }
    //     }

    //     return $this;
    // }

    

    
    
   
}
