<?php

namespace App\DataProviders;

use App\Entity\Complement;
use App\Repository\TailleRepository;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $portionRepo;
    private $tailleRepo;

    public function __construct(TailleRepository $tailleRepo,PortionFriteRepository $portionRepo)
    {
        $this->tailleRepo=$tailleRepo;
        $this->portionRepo=$portionRepo;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;
    }
  
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): array
    {
        // dd("ok");
        if(Complement::class === $resourceClass){
            return  [
                    ["portion"=>$this->portionRepo->findAll()],
                    ["taille"=>$this->tailleRepo->findAll()]
            ];
            
        }
        // $complements=[];
        // $complements["portionRepo"]=$this->portionRepo->findAll();  
        // $complements["tailleRepo"]=$this->tailleRepo->findAll();
        
        // return $complements;
    }
    
}