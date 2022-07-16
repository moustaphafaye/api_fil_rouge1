<?php

namespace App\Entity;

use DateTime;
use App\DataPersist\Persist;
use App\Entity\CommandeBoisson;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CommandeTailleBoisson;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


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

    #[Groups(["commande:ajouter","commander:list","commander:detail","commandes:of:client"])]
    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[Groups(["commande:ajouter","commander:list","commander:detail","commandes:of:client"])]
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

    #[Assert\Valid()]
    #[Assert\NotBlank]
    #[Groups(["commander","commander:detail"])]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeBurger::class,cascade:['Persist'])]
    private $commandeburger;

    #[Groups(["commander","commander:detail"])]
    #[Assert\Valid()]
    #[Assert\NotBlank]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeMenu::class,cascade:['Persist'])]
    private $commandemenu;

    // #[Groups(["commander"])]
    // #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeTaille::class,cascade:['Persist'])]
    // private $commandetaille;

    #[Groups(["commander","commander:detail"])]
    #[Assert\Valid()]
    #[Assert\NotBlank]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeFrite::class,cascade:['Persist'])]
    private $commandefrite;

    #[Groups(["commander","commander:detail"])]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeTailleBoisson::class,cascade:['Persist'])]
    private $commandetailleboisson;

    #[Groups(["commander","commander:detail"])]
    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commande')]
    private $zone;

    #[Groups(["commander","commander:detail"])]
    #[ORM\ManyToOne(targetEntity: Quartier::class, inversedBy: 'commande')]
    private $quartier;

    

    

    

   

    public function __construct()
    {
        
        $this->date=new \DateTime();
        $this->etat="En cours";
        $this->commandeburger = new ArrayCollection();
        $this->commandeMenus = new ArrayCollection();
        $this->commandemenu = new ArrayCollection();
        $this->commandefrite = new ArrayCollection();
        $this->commandetailleboisson = new ArrayCollection();
        
        
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
        $this->etat = $etat;

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
    /**
     * @return Collection<int, CommandeBurger>
     */
    public function getCommandeburger(): Collection
    {
        return $this->commandeburger;
    }

    public function addCommandeburger(CommandeBurger $commandeburger): self
    {
        if (!$this->commandeburger->contains($commandeburger)) {
            $this->commandeburger[] = $commandeburger;
            $commandeburger->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeburger(CommandeBurger $commandeburger): self
    {
        if ($this->commandeburger->removeElement($commandeburger)) {
            // set the owning side to null (unless already changed)
            if ($commandeburger->getCommande() === $this) {
                $commandeburger->setCommande(null);
            }
        }

        return $this;
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
            $commandemenu->setCommande($this);
        }

        return $this;
    }

    public function removeCommandemenu(CommandeMenu $commandemenu): self
    {
        if ($this->commandemenu->removeElement($commandemenu)) {
            // set the owning side to null (unless already changed)
            if ($commandemenu->getCommande() === $this) {
                $commandemenu->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeFrite>
     */
    public function getCommandefrite(): Collection
    {
        return $this->commandefrite;
    }

    public function addCommandefrite(CommandeFrite $commandefrite): self
    {
        if (!$this->commandefrite->contains($commandefrite)) {
            $this->commandefrite[] = $commandefrite;
            $commandefrite->setCommande($this);
        }

        return $this;
    }

    public function removeCommandefrite(CommandeFrite $commandefrite): self
    {
        if ($this->commandefrite->removeElement($commandefrite)) {
            // set the owning side to null (unless already changed)
            if ($commandefrite->getCommande() === $this) {
                $commandefrite->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeTailleBoisson>
     */
    public function getCommandetailleboisson(): Collection
    {
        return $this->commandetailleboisson;
    }

    public function addCommandetailleboisson(CommandeTailleBoisson $commandetailleboisson): self
    {
        if (!$this->commandetailleboisson->contains($commandetailleboisson)) {
            $this->commandetailleboisson[] = $commandetailleboisson;
            $commandetailleboisson->setCommande($this);
        }

        return $this;
    }

    public function removeCommandetailleboisson(CommandeTailleBoisson $commandetailleboisson): self
    {
        if ($this->commandetailleboisson->removeElement($commandetailleboisson)) {
            // set the owning side to null (unless already changed)
            if ($commandetailleboisson->getCommande() === $this) {
                $commandetailleboisson->setCommande(null);
            }
        }

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, )
    {
        if ((count($this->getCommandeburger())==0) && (count($this->getCommandemenu())==0)) {
            
            $context->buildViolation('Votre commande doit avoir au moins un menu ou un burger')
                    ->addViolation();
        }

        if(((count($this->getCommandeburger())!=0) || (count($this->getCommandemenu())!=0)) && ((count($this->getCommandefrite())==0) || (count($this->getCommandetailleboisson())==0))){
            $context->buildViolation('Votre commande doit avoir au moins un complement')
                    ->addViolation();
        }
        

    }
    

    

    

    

    

   
}
