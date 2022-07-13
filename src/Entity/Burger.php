<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get_listerBurger"=>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['burger:list:simple']]
            ],
       "post"=> [
        'status' => Response::HTTP_CREATED,
        'input_formats' => [
        'multipart' => ['multipart/form-data']],
        'denormalization_context' => ['groups' => ['ajouter']],
        'normalization_context' => ['groups' => ['burger:all']],
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource"
        ]],
    itemOperations:["put"=>[
                    "security" => "is_granted('ROLE_GESTIONNAIRE')",
                    "security_message"=>"Vous n'avez pas access à cette Ressource",
                            ],
                    "get"=>[
                        'method' => 'get',
                        'status' => Response::HTTP_OK,
                        'normalization_context' => ['groups' => ['burger:all']],
                        ]],

                
                        subresourceOperations: [
                            'api_users_burgers_get_subresource' => [
                                'method' => 'GET',
                                'normalization_context' => [ 'groups' => ['user:of:burger'],
                                "security" => "is_granted('ROLE_GESTIONNAIRE')",
                                "security_message"=>"Vous n'avez pas access à cette Ressource"
                                ]
                            ]
                        ]
)]
class Burger extends Produit
{
    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    private $menuburger;

    public function __construct()
    {
        parent::__construct();
        $this->menuburger = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuburger(): Collection
    {
        return $this->menuburger;
    }

    public function addMenuburger(MenuBurger $menuburger): self
    {
        if (!$this->menuburger->contains($menuburger)) {
            $this->menuburger[] = $menuburger;
            $menuburger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuburger(MenuBurger $menuburger): self
    {
        if ($this->menuburger->removeElement($menuburger)) {
            // set the owning side to null (unless already changed)
            if ($menuburger->getBurger() === $this) {
                $menuburger->setBurger(null);
            }
        }

        return $this;
    }
}
