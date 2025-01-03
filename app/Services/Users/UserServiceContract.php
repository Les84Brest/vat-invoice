<?php

namespace App\Services\Users;

use App\Models\User;

/**
 * Interface for UserService contracts.
 */
interface UserServiceContract
{
    /**
     * Update a user with the provided data.
     *
     * @param User $user The user to update.
     * @param array $data The data to update the user with.
     * @return User The updated user.
     */
    public function update(User $user, array $data): User;

    /**
     * Store a new user with the provided data.
     *
     * @param array $data The data to create the user with.
     * @return User The newly created user.
     */
    public function store(array $data): User;
}
