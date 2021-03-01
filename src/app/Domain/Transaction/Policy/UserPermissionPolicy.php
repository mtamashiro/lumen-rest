<?php


namespace Domain\Transaction\Policy;

use Domain\User\Models\JuridicalPerson;
use Domain\User\Models\User;

class UserPermissionPolicy implements UserPermissionPolicyInterface
{

    public function isTransferAllowed(User $user): bool
    {
        if ($user->person instanceof JuridicalPerson) {
            return false;
        } else {
            return true;
        }
    }
}
