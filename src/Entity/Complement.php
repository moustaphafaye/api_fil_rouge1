<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Array_;
use App\Repository\ComplementRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;

// #[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource(collectionOperations:[
    "get_catalogue"=>[
        'method' => 'get',
        'path'=>'/complement',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['complement']],
        
]])]
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
