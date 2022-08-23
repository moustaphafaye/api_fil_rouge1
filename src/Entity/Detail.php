<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DetailRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

// #[ORM\Entity(repositoryClass: DetailRepository::class)]
#[ApiResource(
    itemOperations:[
    'get'=>[
        "method" => "get",
        "status" => Response::HTTP_OK,
        'normalization_context'=>['groups'=>['detaile','koni']]
    ],
])]
class Detail
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    #[Groups(["detaile"])]
    public ?int $id=null;

    // #[Groups(["detaile"])]
    // public ?Menu $menu;  
    
    // #[Groups(["detaile"])]
    // public ?Burger $burger;

    #[Groups("detaile")]
    public $produit;


    #[SerializedName("Taillee")]
    #[Groups(["detaile",'koni'])]
    public array $boisson;
    
    
    #[Groups(["detaile"])]
    public array $frite;


    // #[Groups(["detaile"])]
    // public array $munberger;
    // public function getId(): ?int
    // {
    //     return $this->id;
    // }
}
