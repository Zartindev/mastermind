<?php
namespace App\Security;

use App\Entity\Joueur;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $joueur)
    {
        if (!$joueur instanceof Joueur) {
            return;
        }
        if (!$joueur->getIsActive()) {
            throw new CustomUserMessageAuthenticationException(
                'Un compte inactif ne peut pas se connecter'
            );
        }
    }
    public function checkPostAuth(UserInterface $joueur)
    {
        $this->checkPreAuth($joueur);
    }
}