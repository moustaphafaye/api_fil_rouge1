<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(collectionOperations:["get",
"post"=>[
    'status' => Response::HTTP_CREATED,
    'denormalization_context' => ['groups' => ['add:zone']]]],
    itemOperations:["put","get"])]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["commander"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["add:zone"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    
    #[Groups(["add:zone"])]
    #[ORM\Column(type: 'integer')]
    private $prix;

    #[Groups(["add:zone","commander"])]
    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    private $quartier;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    private $commande;

   

    public function __construct()
    {
        $this->quartier = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Quartier>
     */
    public function getQuartier(): Collection
    {
        return $this->quartier;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartier->contains($quartier)) {
            $this->quartier[] = $quartier;
            $quartier->setZone($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartier->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getZone() === $this) {
                $quartier->setZone(null);
            }
        }

        return $this;
    }

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
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
            }
        }

        return $this;
    }

  
}
