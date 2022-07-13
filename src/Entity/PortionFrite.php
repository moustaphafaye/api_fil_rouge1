<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource]
class PortionFrite extends Produit
{
    #[ORM\OneToMany(mappedBy: 'portionFrite', targetEntity: MenuPortionFrite::class)]
    private $menuprotionfrite;

    public function __construct()
    {
        parent::__construct();
        $this->menuprotionfrite = new ArrayCollection();
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
}
