<?php
namespace App\Services\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 *
 * This class provides methods to manage user data, including updating and creating users.
 */
class UserService implements UserServiceContract
{
    /**
     * Updates an existing user with the provided data.
     *
     * @param User $user The user model instance to be updated.
     * @param array $data The data to update the user with.
     * @return User The updated user model instance.
     */
    public function update(User $user, array $data): User
    {
        $preparedData = $this->prepareUserData($data);
        $user->update($preparedData);
        return User::find($user->id);
    }

    /**
     * Creates a new user with the provided data.
     *
     * @param array $data The data to create the user with.
     * @return User The newly created user model instance.
     */
    public function store(array $data): User
    {
        $preparedData = $this->prepareUserData($data);
        $user = User::create($preparedData);
        return $user;
    }

    /**
     * Prepares user data for storage or update.
     *
     * This method hashes the password if it is present in the data array.
     *
     * @param array $data The user data to prepare.
     * @return array The prepared user data with hashed password if applicable.
     */
    private function prepareUserData(array $data): array
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $data;
    }
}