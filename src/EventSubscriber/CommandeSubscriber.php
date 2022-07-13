<?php

namespace App\EventSubscriber;

use Doctrine\ORM\Events;
use App\Repository\BurgerRepository;
use App\Repository\BoissonRepository;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandeSubscriber implements EventSubscriberInterface
{
    public function __construct(BurgerRepository $burger,BoissonRepository $boisson)
    {
        $this->burger=$burger;
        $this->boisson=$boisson;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }
    public function sommeCommande(){
        // $this->burger
    }
    public function prePersist(LifecycleEventArgs $args)
    {
        // if ($args->getObject() instanceof Burger) {
        //     $args->getObject()->setUser($this->getUser());
        // }
    }
}
