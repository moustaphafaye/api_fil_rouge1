<?php
namespace App\Services;

use App\Entity\Commande;

 class CalculPrixCommandeService{
    private $prix = 0;
       public function calculPrixCommade($data){
        
        if ($data instanceof Commande) {
            // foreach ($data->getProduits() as $produits) {
                // $this->prix += $produits->getPrix();
            }
            $data->setMontant($this->prix);
        }
    //    } 
 }