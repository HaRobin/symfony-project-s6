<?php

namespace App\Security\Voter;

use App\Entity\Enum\UserRoles;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ClientVoter extends Voter
{
    public const EDIT = 'CLIENT_EDIT';
    public const VIEW = 'CLIENT_VIEW';
    public const DELETE = 'CLIENT_DELETE';
    public const ADD = 'CLIENT_ADD';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE, self::ADD])
            && $subject instanceof \App\Entity\Client;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Grant all permissions to all admins
        if (in_array(UserRoles::Admin->value, $user->getRoles(), true)) {
            return true;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                if (in_array(UserRoles::Manager->value, $user->getRoles(), true)) {
                    return true;
                }
                return $user->getUserIdentifier() === $subject->getUserIdentifier();

            case self::VIEW:
                if (in_array(UserRoles::Manager->value, $user->getRoles(), true)) {
                    return true;
                }

            case self::DELETE:
                // logic to determine if the user can DELETE
                // return true or false
                break;

            case self::ADD:
                // logic to determine if the user can ADD
                // return true or false
                break;
        }

        return false;
    }
}
