<?php

namespace App\Entity;

use App\Entity\TailleBoisson;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    collectionOperations:["get"=>[
    'status' => Response::HTTP_CREATED,
    // 'denormalization_context' => ['groups' => ['add:taille']],  
    'normalization_context' => ['groups' => ['list:taile']]],
    "post"=>[
        'status' => Response::HTTP_CREATED,
        'denormalization_context' => ['groups' => ['add:taille']],  
        // 'normalization_context' => ['groups' => ['add:boisson:p']] 
    ]],

    itemOperations:["put","get"])]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["add:boisson","detaile","list:taile","commander","complement","ajouter:menutaille","ajouter:menu","ajouter:menu","menu:list","boisson:modifier","commander:detail"])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["add:taille","list:taile","detaile","complement","boisson:list","boisson:taille","menu:simple","commander:detail"])]
    private $Prix;

    #[Groups(["add:taille","list:taile","detaile","boisson:list","complement","boisson:taille","menu:simple","commander:detail"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $libelle;

   

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenuTaille::class)]
    private $menutaille;

    #[ApiSubresource()]
    #[Groups(["detaile","list:taile"])]
    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: TailleBoisson::class)]
    private $tailleboisson;

    public function __construct()
    {
        $this->menutaille = new ArrayCollection();
        $this->tailleboisson = new ArrayCollection();
    }

    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(?int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenutaille(): Collection
    {
        return $this->menutaille;
    }
    

    public function addMenutaille(MenuTaille $menutaille): self
    {
        if (!$this->menutaille->contains($menutaille)) {
            $this->menutaille[] = $menutaille;
            $menutaille->setTaille($this);
        }

        return $this;
    }

    public function removeMenutaille(MenuTaille $menutaille): self
    {
        if ($this->menutaille->removeElement($menutaille)) {
            // set the owning side to null (unless already changed)
            if ($menutaille->getTaille() === $this) {
                $menutaille->setTaille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleboisson(): Collection
    {
        return $this->tailleboisson;
    }

    public function addTailleboisson(TailleBoisson $tailleboisson): self
    {
        if (!$this->tailleboisson->contains($tailleboisson)) {
            $this->tailleboisson[] = $tailleboisson;
            $tailleboisson->setTaille($this);
        }

        return $this;
    }

    public function removeTailleboisson(TailleBoisson $tailleboisson): self
    {
        if ($this->tailleboisson->removeElement($tailleboisson)) {
            // set the owning side to null (unless already changed)
            if ($tailleboisson->getTaille() === $this) {
                $tailleboisson->setTaille(null);
            }
        }

        return $this;
    }

   

   

    
}
