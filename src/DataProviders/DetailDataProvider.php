<?php
// api/src/DataProvider/BlogPostItemDataProvider.php

namespace App\DataProviders;

use App\Entity\Detail;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\TailleRepository;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\MenuBurger;
use App\Repository\BoissonRepository;
use App\Repository\MenuBurgerRepository;
use App\Repository\ProduitRepository;

final class DetailDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{

    private $a;
    public function __construct(BoissonRepository $boissonRepository, ProduitRepository $produitRepository, MenuRepository $menuRepository,BurgerRepository $burgerRepository,TailleRepository $tailleRepository,PortionFriteRepository $friteRepository,MenuBurgerRepository $menuBurgerRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->burgerRepository = $burgerRepository;
        $this->tailleRepository = $tailleRepository;
        $this->friteRepository = $friteRepository;
        $this->menuBurgerRepository=$menuBurgerRepository;
        $this->produitRepository=$produitRepository;
        $this->boissonRepository=$boissonRepository;

    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Detail::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Detail
    {
        $detail= new Detail();
        $detail->id=$id;
        $a=$this->produitRepository->findAll(['type'=>'menu']);
        // dd($a);
        $menu=$this->menuRepository->findOneBy(['id'=>$id]);
        $burger=$this->burgerRepository->findOneBy(['id'=>$id]);
        if($menu==null){
            $detail->burger=$burger;
        }else{
            $detail->menu=$menu;
        }
        $detail->boisson=$this->tailleRepository->findAll([]);
        $detail->frite=$this->friteRepository->findAll();
        //  $detail->menuberger=$this->menuBurgerRepository->findAll(['menu_id'=>$id]);
        //  dd($detail->menuberger=$this->menuBurgerRepository->findBy(['id_menu'=>$id]));
        // $detail->menu=
        // Retrieve the blog post item from somewhere then return it or null if not found
        return  $detail;
    }
}