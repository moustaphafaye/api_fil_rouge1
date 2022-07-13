<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(collectionOperations:["get",
                        "post"=>[
                    'status' => Response::HTTP_CREATED,
                    'denormalization_context' => ['groups' => ['livraison']],
                        ]],
itemOperations:["put","get"])]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande","commander:detail"])]
    private $id;

    #[Groups(["commander:detail"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $montantTotal;

    #[Groups(["commande","livraison","commander:detail"])]
    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraison')]
    private $livreur;

    #[Groups(["livraison"])]
    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
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
}
