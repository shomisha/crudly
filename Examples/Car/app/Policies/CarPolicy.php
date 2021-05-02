<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;
use Shomisha\Crudly\Exceptions\IncompletePolicyException;

class CarPolicy
{
    public function viewAny(User $user)
    {
        throw IncompletePolicyException::missingAction('viewAny');
    }

    public function view(User $user, Car $car)
    {
        throw IncompletePolicyException::missingAction('view');
    }

    public function create(User $user)
    {
        throw IncompletePolicyException::missingAction('create');
    }

    public function update(User $user, Car $car)
    {
        throw IncompletePolicyException::missingAction('update');
    }

    public function delete(User $user, Car $car)
    {
        throw IncompletePolicyException::missingAction('delete');
    }
}