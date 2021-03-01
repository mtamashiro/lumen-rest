<?php


namespace Domain\Transaction\Policy;


use Domain\User\Models\User;

Interface UserPermissionPolicyInterface
{
    public function isTransferAllowed(User $user) : bool;
}
