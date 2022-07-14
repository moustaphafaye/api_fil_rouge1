<?php

namespace App\EventSubscriber;


use App\Entity\Commande;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
// use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ClientSubcriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
            $this->token = $tokenStorage->getToken();
    }
    public static function getSubscribedEvents(): array
        {
            return [
                Events::prePersist,
            ];
        }
       
    private function getClient() 
        {
        //dd($this->token);
            if (null === $token = $this->token) {
                return null;
                // dd($token);
            }
            if (!is_object($user = $token->getUser())) {
                // e.g. anonymous authentication
                
            return null;
        }
            return $user;
        }
    public function prePersist(LifecycleEventArgs $args)
        {
            
            if ($args->getObject() instanceof Commande) {
                $args->getObject()->setClient($this->getClient());
            }
            
        }
}
