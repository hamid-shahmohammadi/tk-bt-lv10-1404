<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HarmType;
use Illuminate\Auth\Access\HandlesAuthorization;

class HarmTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_harm::type');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HarmType  $harmType
     * @return bool
     */
    public function view(User $user, HarmType $harmType): bool
    {
        return $user->can('view_harm::type');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_harm::type');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HarmType  $harmType
     * @return bool
     */
    public function update(User $user, HarmType $harmType): bool
    {
        return $user->can('update_harm::type');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HarmType  $harmType
     * @return bool
     */
    public function delete(User $user, HarmType $harmType): bool
    {
        return $user->can('delete_harm::type');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_harm::type');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HarmType  $harmType
     * @return bool
     */
    public function forceDelete(User $user, HarmType $harmType): bool
    {
        return $user->can('force_delete_harm::type');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_harm::type');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HarmType  $harmType
     * @return bool
     */
    public function restore(User $user, HarmType $harmType): bool
    {
        return $user->can('restore_harm::type');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_harm::type');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HarmType  $harmType
     * @return bool
     */
    public function replicate(User $user, HarmType $harmType): bool
    {
        return $user->can('replicate_harm::type');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_harm::type');
    }

}
