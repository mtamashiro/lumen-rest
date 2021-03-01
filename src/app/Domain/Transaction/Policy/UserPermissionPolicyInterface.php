<?php


namespace Domain\Transaction\Policy;

use Domain\User\Models\User;

interface UserPermissionPolicyInterface
{
    public function isTransferAllowed(User $user) : bool;
}
