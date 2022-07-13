<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    collectionOperations:["get",
                        "post"],
itemOperations:["put","get"])]
class Gestionnaire extends User
{
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Burger::class)]
    // #[ApiSubresource()]  
    private $burger;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Menu::class)]
    private $menu;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    private $produit;

    public function __construct()
    {
        $this->setRoles(["ROLE_GESTIONNAIRE"]);
        $this->burger = new ArrayCollection();
        $this->menu = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->produit = new ArrayCollection();
        
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurger(): Collection
    {
        return $this->burger;
    }

    // public function addBurger(Burger $burger): self
    // {
    //     if (!$this->burger->contains($burger)) {
    //         $this->burger[] = $burger;
    //         $burger->setGestionnaire($this);
    //     }

    //     return $this;
    // }

    // public function removeBurger(Burger $burger): self
    // {
    //     if ($this->burger->removeElement($burger)) {
    //         // set the owning side to null (unless already changed)
    //         if ($burger->getGestionnaire() === $this) {
    //             $burger->setGestionnaire(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Menu>
    //  */
    // public function getMenu(): Collection
    // {
    //     return $this->menu;
    // }

    // public function addMenu(Menu $menu): self
    // {
    //     if (!$this->menu->contains($menu)) {
    //         $this->menu[] = $menu;
    //         $menu->setGestionnaire($this);
    //     }

    //     return $this;
    // }

    // public function removeMenu(Menu $menu): self
    // {
    //     if ($this->menu->removeElement($menu)) {
    //         // set the owning side to null (unless already changed)
    //         if ($menu->getGestionnaire() === $this) {
    //             $menu->setGestionnaire(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setGestionnaire($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getGestionnaire() === $this) {
                $commande->setGestionnaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
            $produit->setGestionnaire($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getGestionnaire() === $this) {
                $produit->setGestionnaire(null);
            }
        }

        return $this;
    }
}
