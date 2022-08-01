<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource]
class Client extends User
{
   

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["commander:detail","commandes:of:client"])]
    private $adresse;

    #[Groups(["commander:detail","commandes:of:client"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $telephone;

    #[ApiSubresource]
    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private $commande;

    // 
    // #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    // private $commande;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles(["ROLE_CLIENT"]);
        $this->commande = new ArrayCollection();
    }

   



    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    // /**
    //  * @return Collection<int, Commande>
    //  */
    // public function getCommande(): Collection
    // {
    //     return $this->commande;
    // }

    // public function addCommande(Commande $commande): self
    // {
    //     if (!$this->commande->contains($commande)) {
    //         $this->commande[] = $commande;
    //         $commande->setClient($this);
    //     }

    //     return $this;
    // }

    // public function removeCommande(Commande $commande): self
    // {
    //     if ($this->commande->removeElement($commande)) {
    //         // set the owning side to null (unless already changed)
    //         if ($commande->getClient() === $this) {
    //             $commande->setClient(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

   
   
}
