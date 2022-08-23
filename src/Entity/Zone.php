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
#[ApiResource(collectionOperations:["get"=>[
    'method'=>'get',
    'status' => Response::HTTP_CREATED,
    'normalization_context'=>['groups'=>['list:zone']]
],
"post"=>[
    'status' => Response::HTTP_CREATED,
    'denormalization_context' => ['groups' => ['add:zone']]]],
    itemOperations:["put","get"=>['status' => Response::HTTP_CREATED,
    'normalization_context'=>['groups'=>['uniquezone']]]
    ])]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["commander:detail","list:zone","commandes:of:client","commander:list","uniquezone"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["add:zone","commander:detail","list:zone","commandes:of:client","commander:list","uniquezone"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    
    #[Groups(["add:zone","list:zone"])]
    #[ORM\Column(type: 'integer')]
    private $prix;

     #[Groups(["list:zone"])]
    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    private $quartier;


    #[Groups(["list:zone","uniquezone"])]
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
