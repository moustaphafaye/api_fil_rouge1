<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(collectionOperations:["get"=>[
                    'status' => Response::HTTP_CREATED,
                    'normalization_context' => ['groups' => ['commander:list']],
                    ],
                "post"=>[
                    'status' => Response::HTTP_CREATED,
                    'denormalization_context' => ['groups' => ['commander']],
                    'normalization_context' => ['groups' => ['commande:ajouter']],
                    // "security" => "is_granted('ROLE_GESTIONNAIRE')",
                    // "security_message"=>"Vous n'avez pas access à cette Ressource"
                ]],
itemOperations:["put","get"=>['status' => Response::HTTP_CREATED,
                'normalization_context' => ['groups' => ['commander:detail']]]],
    subresourceOperations:[
        'api_clients_commandes_get_subresource' =>[
            
            'method' => 'GET',
            'normalization_context' => [ 'groups' => ['commandes:of:client'],]

        ]
    ]
                )]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["livraison"])]
    private $id;
    

    #[Groups(["commander","commande:ajouter","commander:detail","commandes:of:client"])]
    #[ORM\Column(type: 'string', nullable: true)]
    private $nCommande;

    #[Groups(["commander","commande:ajouter","commander:list","commander:detail","commandes:of:client"])]
    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[Groups(["commander","commande:ajouter","commander:list","commander:detail","commandes:of:client"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $etat;

    #[Groups(["commander","commande:ajouter","commander:list","commander:detail","commandes:of:client"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $montant;

    #[Groups(["commander","commander:detail"])]
    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;
  
    #[Groups(["commander","commander:detail","commandes:of:client"])]
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commande')]
    private $client;

    #[Groups(["commander","commander:detail"])]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;

    
    #[Groups(["commander"])]
    #[ORM\ManyToMany(targetEntity: Produit::class, mappedBy: 'commande')] 
    private $produits;

    #[ORM\ManyToOne(targetEntity: Quartier::class, inversedBy: 'commande')]
    private $quartier;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNCommande(): ?string
    {
        return $this->nCommande;
    }

    public function setNCommande(?string $nCommande): self
    {
        $this->nCommande = $nCommande;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = "En cours";

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    
    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->addCommande($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removeCommande($this);
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getQuartier(): ?Quartier
    {
        return $this->quartier;
    }

    public function setQuartier(?Quartier $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }
}
