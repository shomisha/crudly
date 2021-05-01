<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Shomisha\Crudly\Exceptions\IncompletePolicyException;

class PostPolicy
{
    public function viewAny(User $user)
    {
        throw IncompletePolicyException::missingAction('viewAny');
    }

    public function view(User $user, Post $post)
    {
        throw IncompletePolicyException::missingAction('view');
    }

    public function create(User $user)
    {
        throw IncompletePolicyException::missingAction('create');
    }

    public function update(User $user, Post $post)
    {
        throw IncompletePolicyException::missingAction('update');
    }

    public function delete(User $user, Post $post)
    {
        throw IncompletePolicyException::missingAction('delete');
    }

    public function forceDelete(User $user, Post $post)
    {
        throw IncompletePolicyException::missingAction('forceDelete');
    }

    public function restore(User $user, Post $post)
    {
        throw IncompletePolicyException::missingAction('restore');
    }
}