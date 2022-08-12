<?php
// src/DataPersister/UserDataPersister.php

namespace App\DataPersist;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\Produit;
use App\Entity\PortionFrite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

/**
 *
 */
class ProduitDataPersister implements DataPersisterInterface
{
    private $_entityManager;
    private $prix = 0;
   

    public function __construct(
        EntityManagerInterface $entityManager,RequestStack $requestStack

    ) {
        $this->requestStack=$requestStack;
        $this->_entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Produit;
        
    }

    /**
     * @param Produit $data
     */
    public function persist($data, array $context = [])
    {  

        
        if ($data instanceof Boisson or $data instanceof PortionFrite) {
        //    dd($data->getFile()->getRealPath());
            $image= stream_get_contents(fopen($data->getFile()->getRealPath(),"rt"));
            $data->setImage($image);
            // $data->setPrix($this->prix);
        } 
        elseif ($data instanceof Menu) {
           
            foreach ($data->getMenuburger() as $burgers) 
            {
                $this->prix += $burgers->getBurger()->getPrix()*($burgers->getQuentity());
                // $this->burgers->getQuentity();
            }
            foreach ($data->getMenutaille() as $menutaille) {
                $this->prix += $menutaille->getTaille()->getPrix()*($menutaille->getQuantity());
            }
            // //  foreach($data->getBoisson() as $boisson){

             foreach ($data->getMenuportionfriet() as $Menuportion) {
                    $this->prix += $Menuportion->getPortionFrite()->getPrix();
             }
            $data->setPrix($this->prix);
            $image= stream_get_contents(fopen($data->getFile()->getRealPath(),"rt"));
            $data->setImage($image);
            
        }
        else {
           
            // $data instanceof Burger;
            $image= stream_get_contents(fopen($data->getFile()->getRealPath(),"rt"));
            $data->setImage($image);
         }
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
