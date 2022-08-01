<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProviders;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
// use App\Entity\BlogPoiterablest;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Repository\BurgerRepository;

final class CatalogueDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $menuRepo;
    private $burgerRepo;

    public function __construct(MenuRepository $menuRepo,BurgerRepository $burgerRepo)
    {
        $this->menuRepo=$menuRepo;
        $this->burgerRepo=$burgerRepo;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): array
    {
        if(Catalogue::class === $resourceClass){
            return  [
                
                    ["menu"=>$this->menuRepo->findAll()],
                    ["burger"=>$this->burgerRepo->findAll()]
            ];
            
        }
        
    }
}