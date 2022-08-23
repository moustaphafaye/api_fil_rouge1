<?php
// src/DataPersister/UserDataPersister.php

namespace App\DataPersist;


use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\CalculPrixCommandeService;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Repository\TailleBoissonRepository;

/**
 *
 */
class CommandeDataPersiter implements DataPersisterInterface
{
    private $_entityManager;
    // private $prix = 0;
    public function __construct(
        EntityManagerInterface $entityManager,
        CalculPrixCommandeService $calculPrix,
    ) {
        $this->_entityManager = $entityManager;
        $this->calculPrix = $calculPrix;
       

    }
    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
     
        return $data instanceof Commande;
        
    }
    /**
     * @param Commande $data
     */
    public function persist($data, array $context = [])
    {
        
        $this->calculPrix->calculPrixCommade($data);
       
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }
    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
} 
