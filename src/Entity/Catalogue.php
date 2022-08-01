<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CatalogueRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;

// #[ORM\Entity(repositoryClass: CatalogueRepository::class)]
#[ApiResource(collectionOperations:[
    "get_catalogue"=>[
        'method' => 'get',
        'path'=>'/catalogue',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['catalogue']]
]]
)]
class Catalogue
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    public ?int $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
