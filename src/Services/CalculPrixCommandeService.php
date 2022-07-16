<?php
namespace App\Services;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TailleBoissonRepository;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

 class CalculPrixCommandeService  implements DataPersisterInterface{
    private $prix = 0;
    private $qt = 0;
    private $b = 0;
    private $c = 0;
    private $data1;
    public function __construct(TailleBoissonRepository $repo,EntityManagerInterface $entityManager)
    {
        $this->_entityManager = $entityManager;
        $this->repo=$repo;
    }
    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data ;
    }
   
       public function calculPrixCommade($data){
        
       
        if ($data instanceof Commande) {
            foreach ($data->getCommandeburger() as $burger) {
                
                $this->prix += ($burger->getBurger()->getPrix()*$burger->getQuantite());
                
            }
            foreach ($data->getCommandemenu() as $menu){
                $this->prix += ($menu->getMenu()->getPrix())*($menu->getQuantite());
            }
            foreach($data->getCommandefrite() as $frite){
                $this->prix += ($frite->getPortionFrite()->getPrix())*($frite->getQuantite());
            }
            foreach($data->getCommandetailleboisson() as $taille){
                $this->prix += ($taille->getTailleBoisson()->getTaille()->getPrix()*($taille->getQuantitetailleboisson()));
                // $a=$taille->getTailleBoisson()->getId();
                $this->b=$taille->getTailleBoisson()->getQquantitetailleboissonstock();
                $this->c +=$taille->getQuantitetailleboisson();
                if(($this->b)>($this->c)){
                    // $this->repo->findById($a)->$taille->getTailleBoisson()->setQuantitetailleboissonstock(($this->b)-($this->c));
                   $data1= $taille->getTailleBoisson()->setQuantitetailleboissonstock(($this->b)-($this->c));
                   $this->_entityManager->persist($data1);
                    $this->_entityManager->flush();
                    // dd($this->repo->findById($a));
                    // $taille->getTailleBoisson()->setQuantitetailleboissonstock(($this->b)-($this->c));
                }
            }
           

            // dd(($this->b)-($this->c));
            // dd($this->repo->findById($a));
            // ($this->repo->findById($a)->setQquantitetailleboissonstock(($this->b)-($this->c)));

            $this->qt=$data->getZone()->getPrix();
            $this->prix +=$this->qt;
            $data->setMontant($this->prix);
        }
      }
      public function persist($data, array $context = []){
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