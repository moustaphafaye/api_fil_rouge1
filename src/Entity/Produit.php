<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;


#[ORM\Entity(repositoryClass: ProduitRepository::class)]

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["produit" => "Produit", "menu" => "Menu","portionfrite"=>"PortionFrite","burger"=>"Burger","boisson"=>"Boisson"])]
#[ApiResource(collectionOperations:[
    "get"=>[
        'method' => 'get',
        // 'path'=>'/listerMenu',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['produit']],
]],

        itemOperations:[
            "get"=>[
                'method' => 'get',
                'status' => Response::HTTP_OK,
                'normalization_context' => ['groups' => ['produit']],
                ]]
        
)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["ajouter:menutaille","detail","menu:simple","menu:of:burger","complement","catalogue","menu:all","burger:list:simple","ajouter:menuburger","burger:all","user:of:burger","ajouter:menu","menu:list","modifier:menu","commander"])]
    protected $id;

    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[Groups(["burger:list:simple","produit","detail","menu:of:burger","catalogue","complement","menuburger","burger:all","list:taile","boisson:taille","ajouter:menu","ajouter","user:of:burger","menu:simple","menu:list","add:boisson","add:boisson:p","boisson:list"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $nom;

    // #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[Groups(["burger:list:simple","produit","detail","menu:of:burger","burger:all","menu:all","complement","catalogue","ajouter","user:of:burger","menu:simple","menu:list"])]
    #[ORM\Column(type: 'float', nullable: true)]
    protected $prix; 

    #[Groups(["ajouter","catalogue","complement","produit","modifier"])] 
    #[ORM\Column(type: 'blob', nullable: true)]
    protected $image;

     
     #[UploadableField(mapping:"media_object", fileNameProperty:"filePath")]
    
    #[Groups(["ajouter","ajouter:menu"])]
    // #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?File $file = null
;

    #[Groups(["boisson:list","boisson:taille","ajouter"])]
    #[ORM\Column(type: 'boolean', nullable: true)]
    protected $isEtat=true;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produit')]
    private $gestionnaire;

    #[Groups(["produit","detail"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[Groups(["produit"])]
    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $type;


    public function __construct()
    {
        
    }

    // #[Groups(["burger:all","user:of:burger","add:boisson"])]
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }
    
    public function setNom(?string $nom): self
    {
        
        $this->nom = $nom;
        
        return $this;
    }
    
    public function getPrix(): ?float
    {
        return $this->prix;
    }
    
    public function setPrix(?float $prix): self
    {
        
        $this->prix = $prix;
        
        return $this;
    }
    
    public function getImage(): ?string
    {
       
        if($this->image===null){
          return $this->image;  
        }else{
            $image=base64_encode(stream_get_contents($this->image));
            return $image;
        }
       
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(?bool $isEtat): self
    {
        $this->isEtat = $isEtat;

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
     * Get the value of file
     */ 
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */ 
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
