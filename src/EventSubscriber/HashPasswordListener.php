<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(Events::prePersist, method: 'hashPassword', entity: User::class)]
#[AsEntityListener(Events::preUpdate, method: 'hashPassword', entity: User::class)]
class HashPasswordListener
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {    
    }

    public function hashPassword(User $user): void
    {
        if (!$user->getPlainPassword()) {
            return;
        }

        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $user->getPlainPassword()
        );
        $user->setPassword($hashedPassword);
    }
}