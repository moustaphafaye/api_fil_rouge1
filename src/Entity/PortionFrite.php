<?php

namespace App\Entity;

use App\Entity\CommandeFrite;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(collectionOperations:[
    "post"=>[
    "status" => Response::HTTP_OK,
    'input_formats' => [
    'multipart' => ['multipart/form-data']],
    'denormalization_context' => ['groups' => ['frite']],
    'normalization_context' => ['groups' => ['portion']]
    
]])]
class PortionFrite extends Produit
{
    #[ORM\OneToMany(mappedBy: 'portionFrite', targetEntity: MenuPortionFrite::class)]
    private $menuprotionfrite;

    #[ORM\OneToMany(mappedBy: 'portionFrite', targetEntity: CommandeFrite::class)]
    private $commandefrite;

    

   

   

    public function __construct()
    {
        parent::__construct();
        $this->menuprotionfrite = new ArrayCollection();
        $this->commandefrite = new ArrayCollection();
        
    }

    /**
     * @return Collection<int, MenuPortionFrite>
     */
    public function getMenuprotionfrite(): Collection
    {
        return $this->menuprotionfrite;
    }

    public function addMenuprotionfrite(MenuPortionFrite $menuprotionfrite): self
    {
        if (!$this->menuprotionfrite->contains($menuprotionfrite)) {
            $this->menuprotionfrite[] = $menuprotionfrite;
            $menuprotionfrite->setPortionFrite($this);
        }

        return $this;
    }

    public function removeMenuprotionfrite(MenuPortionFrite $menuprotionfrite): self
    {
        if ($this->menuprotionfrite->removeElement($menuprotionfrite)) {
            // set the owning side to null (unless already changed)
            if ($menuprotionfrite->getPortionFrite() === $this) {
                $menuprotionfrite->setPortionFrite(null);
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
            $commandefrite->setPortionFrite($this);
        }

        return $this;
    }

    public function removeCommandefrite(CommandeFrite $commandefrite): self
    {
        if ($this->commandefrite->removeElement($commandefrite)) {
            // set the owning side to null (unless already changed)
            if ($commandefrite->getPortionFrite() === $this) {
                $commandefrite->setPortionFrite(null);
            }
        }

        return $this;
    }

    

   

  
    
  

  
}
