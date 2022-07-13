<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComplementRepository;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Array_;

// #[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource]
class Complement
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    private $id;

    private Array $tailles;
    
    private Array $portionfrite;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of tailles
     */ 
    public function getTailles()
    {
        return $this->tailles;
    }

    /**
     * Set the value of tailles
     *
     * @return  self
     */ 
    public function setTailles($tailles)
    {
        $this->tailles = $tailles;

        return $this;
    }

    /**
     * Get the value of portionfrite
     */ 
    public function getPortionfrite()
    {
        return $this->portionfrite;
    }

    /**
     * Set the value of portionfrite
     *
     * @return  self
     */ 
    public function setPortionfrite($portionfrite)
    {
        $this->portionfrite = $portionfrite;

        return $this;
    }
}
