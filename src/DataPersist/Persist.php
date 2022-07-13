<?php
// src/DataPersister/UserDataPersister.php

namespace App\DataPersist;

use App\Entity\User;
use App\Services\EnvoieEmail;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 *
 */
class Persist implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordEncoder,
        EnvoieEmail $envoie
    ) 
    {
        $this->_entityManager = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
        $this->envoie=$envoie;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        if ($data->getFauxpassword()) {
            $data->setPassword(
                $this->_passwordEncoder->hashPassword(
                    $data,
                    $data->getFauxpassword()
                    )
                );
                $data->eraseCredentials();

        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        $this->envoie->emailenvoie($data);
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