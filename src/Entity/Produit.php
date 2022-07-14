<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;


#[ORM\Entity(repositoryClass: ProduitRepository::class)]

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["produit" => "Produit", "menu" => "Menu","portionfrite"=>"PortionFrite","burger"=>"Burger","boisson"=>"Boisson"])]
#[ApiResource]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["ajouter:menutaille","burger:list:simple","ajouter:menuburger","burger:all","user:of:burger","ajouter:menu","modifier:menu","commander"])]
    protected $id;

    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[Groups(["burger:list:simple","menuburger","burger:all","list:taile","boisson:taille","ajouter:menu","ajouter","user:of:burger","menu:simple","menu:list","add:boisson","add:boisson:p","boisson:list"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $nom;

    // #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[Groups(["burger:list:simple","burger:all","ajouter:menu","ajouter","user:of:burger","menu:simple","menu:list"])]
    #[ORM\Column(type: 'float', nullable: true)]
    protected $prix; 

    #[Groups(["ajouter"])] 
    #[ORM\Column(type: 'blob', nullable: true)]
    protected $image;

     
     #[UploadableField(mapping:"media_object", fileNameProperty:"filePath")]
    
    #[Groups(["ajouter"])]
    // #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?File $file = null
;

    #[Groups(["boisson:list","boisson:taille","ajouter"])]
    #[ORM\Column(type: 'boolean', nullable: true)]
    protected $isEtat=true;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produit')]
    private $gestionnaire;


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
        return $this->image;
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
}
