<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(collectionOperations:["get"=>[
                    // 'status' => Response::HTTP_CREATED,
                    'normalization_context' => ['groups' => ['toutlivraison']],
],
                    "post"=>[
                    'status' => Response::HTTP_CREATED,
                    'denormalization_context' => ['groups' => ['livraison']],
                        ]],
 itemOperations:["put","get"=>[
    'status'=>Response::HTTP_CREATED,
    'normalization_context' => ['groups' => ['Ilivraison']]]], 
)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande","commander:detail","toutlivraison","livraisoncommande","Ilivraison"])]
    private $id;

    #[Groups(["commander:detail","toutlivraison","livraisoncommande","Ilivraison"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $montantTotal;

    #[Groups(["commande","livraison","commander:detail","toutlivraison","livraisoncommande"])]
    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraison')]
    private $livreur;

    #[ApiSubresource]
    #[Groups(["livraison","Ilivraison"])]
    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    private $commandes;
   
    #[Groups(["toutlivraison","livraisoncommande","Ilivraison"])]
    #[ORM\Column(type: 'string', length: 40, nullable: true)]
    private $etat;

    #[Groups(["toutlivraison","livraisoncommande"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $N_livraison;

   
    

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->etat='En cours';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantTotal(): ?int
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(?int $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

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
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getNLivraison(): ?string
    {
        return $this->N_livraison;
    }

    public function setNLivraison(?string $N_livraison): self
    {
        $this->N_livraison = $N_livraison;

        return $this;
    }

    
}
