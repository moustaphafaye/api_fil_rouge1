<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["user" => "User", "client" => "Client","livreur"=>"Livreur","gestionnaire"=>"Gestionnaire"])]
#[ApiResource(
    collectionOperations:["get"=>[
        'denormalization_context' => ['groups' => ['user:all']],
        
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource"
    ],
    "post_register" => [
        "method"=>"post",
        'status' => Response::HTTP_CREATED,
        'path'=>'/register',
        // 'denormalization_context' => ['groups' => ['user:write']],
        'normalization_context' => ['groups' => ['user:read:simple']]
        ],
    // "post"=>[
    //     "security" => "is_granted('ROLE_GESTIONNAIRE')",
    //     "security_message"=>"Vous n'avez pas access à cette Ressource"
    // ]
],
itemOperations:["put","get"]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["listcommande","burger:all","ajouter","user:of:burger","user:read:simple","commander","livraison","commander:detail","commandes:of:client"])]
    protected $id;

    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[Groups(["burger:all","user:of:burger","user:read:simple","user:all"])]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    protected $login;

    #[Groups(["user:read:simple"])]
    #[ORM\Column(type: 'json')]
    protected $roles = [];

    // #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[ORM\Column(type: 'string')]
    protected $password;

    // #[ORM\OneToMany(mappedBy: 'user', targetEntity: Burger::class)]
    // #[ApiSubresource]
    // private $burgers;

    
    #[Groups(["listcommande","user:all","commander:detail","commandes:of:client","commander:list"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $nom;

    #[Groups(["listcommande","user:all","commander:detail","commandes:of:client","commander:list"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $prenom;

    #[ORM\Column(type: 'boolean', nullable: true)]
    protected $isEnable;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $expireAT;

    #[ORM\Column(type: 'boolean', nullable: true)]
    protected $isActived;

    // #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[SerializedName("password")]
    protected $Fauxpassword;

    #[ORM\Column(type: 'string', length: 255)]
    protected $token;

    // #[ORM\OneToMany(mappedBy: 'user', targetEntity: Burger::class)]
    // private $burger;

    
  
    public function __construct()
    {
        $this->isEnable=false;
        // $this->burgers = new ArrayCollection();
        $this->generationToken();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    // /**
    //  * @return Collection<int, Burger>
    //  */
    // public function getBurgers(): Collection
    // {
    //     return $this->burgers;
    // }

    // public function addBurger(Burger $burger): self
    // {
    //     if (!$this->burgers->contains($burger)) {
    //         $this->burgers[] = $burger;
    //         $burger->setUser($this);
    //     }

    //     return $this;
    // }

    // public function removeBurger(Burger $burger): self
    // {
    //     if ($this->burgers->removeElement($burger)) {
    //         // set the owning side to null (unless already changed)
    //         if ($burger->getUser() === $this) {
    //             $burger->setUser(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function generationToken(){

        $this->expireAT=new \DateTime("+1day");
        $this->token=rtrim(str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(random_bytes(50))));
    }
    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(?bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    public function getExpireAT(): ?\DateTimeInterface
    {
        return $this->expireAT;
    }

    public function setExpireAT(?\DateTimeInterface $expireAT): self
    {
        $this->expireAT = $expireAT;

        return $this;
    }

    public function isIsActived(): ?bool
    {
        return $this->isActived;
    }

    public function setIsActived(?bool $isActived): self
    {
        $this->isActived = true;

        return $this;
    }

    public function getFauxpassword(): ?string
    {
        return $this->Fauxpassword;
    }

    public function setFauxpassword(?string $Fauxpassword): self
    {
        $this->Fauxpassword = $Fauxpassword;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    // /**
    //  * @return Collection<int, Burger>
    //  */
    // public function getBurger(): Collection
    // {
    //     return $this->burger;
    // }

    // public function addBurger(Burger $burger): self
    // {
    //     if (!$this->burger->contains($burger)) {
    //         $this->burger[] = $burger;
    //         $burger->setUser($this);
    //     }

    //     return $this;
    // }

    // public function removeBurger(Burger $burger): self
    // {
    //     if ($this->burger->removeElement($burger)) {
    //         // set the owning side to null (unless already changed)
    //         if ($burger->getUser() === $this) {
    //             $burger->setUser(null);
    //         }
    //     }

    //     return $this;
    // }

 
}
