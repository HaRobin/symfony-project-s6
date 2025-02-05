<?php

namespace App\Security\Voter;

use App\Entity\Enum\UserRoles;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ProductVoter extends Voter
{
    public const EDIT = 'PRODUCT_EDIT';
    public const VIEW = 'PRODUCT_VIEW';
    public const DELETE = 'PRODUCT_DELETE';
    public const ADD = 'PRODUCT_ADD';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE, self::ADD])
            && $subject instanceof \App\Entity\Product;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Temporary code to grant all permissions to all loged in users
        if (in_array(UserRoles::User->value, $user->getRoles(), true)) {
            return true;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                break;

            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                break;

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
