<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DetailRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ORM\Entity(repositoryClass: DetailRepository::class)]
#[ApiResource(itemOperations:[
    "get"=>[
        "method" => "get",
        "status" => Response::HTTP_OK,
        'normalization_context'=>['groups'=>['detail']]
    ]
])]
class Detail
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    #[Groups(["detail"])]
    public ?int $id=null;

    #[Groups(["detail"])]
    public ?Menu $menu;  
    
    #[Groups(["detail"])]
    public ?Burger $burger;

    
    #[Groups(["detail"])]
    public array $boisson;
    
    
    #[Groups(["detail"])]
    public array $frite;


    #[Groups(["detail"])]
    public array $munberger;
    // public function getId(): ?int
    // {
    //     return $this->id;
    // }
}
