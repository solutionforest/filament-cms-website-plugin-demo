<?php

namespace App\Policies;

use App\Filament\Resources\Shield\RoleResource;
use App\Models\User;
use App\Models\CmsPage;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CmsPagePolicy
{
    use HandlesAuthorization;

    private function isNormalPageResource($resourceClass): bool
    {
        if ($resourceClass) {
            return ! (
                is_subclass_of($resourceClass, \SolutionForest\FilamentCms\Filament\Resources\ContentTypePageBaseResource::class)
                || is_subclass_of($resourceClass, \SolutionForest\FilamentCms\Filament\Resources\DataTypePageBaseResource::class)
            );
        }

        return true;
    }

    private function authorizeCmsPageClass(User $user, $resourceClass, string $abilityPrefix, ?CmsPage $cmsPage): bool
    {
        if (! $resourceClass) {
            return false;
        }

        $permissionIdentifier = FilamentShield::getPermissionIdentifier($resourceClass);
        $entity = data_get(FilamentShield::getResources(), $permissionIdentifier, []);

        $targetAbility = collect(RoleResource::getResourcePermissionOptions($entity))
            ->keys()
            ->first(fn ($permission) => $permission == implode('_', [Str::snake($abilityPrefix), $permissionIdentifier]));

        // missing for v2.0.4
        // 'audit',
        // 'audit_rollback',
        // 'publish',
        // 'unpublish',
        // 'schedule_publish',
        if (! $targetAbility) {
            return false;
        }

        return $user->can($targetAbility);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param ?string $resourceClass
     * @return bool
     */
    public function viewAny(User $user, ?string $resourceClass = null): bool
    {
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'viewAny', null);
        }
        return $user->can('view_any_cms::page');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CmsPage  $cmsPage
     * @param ?string $resourceClass
     * @return bool
     */
    public function view(User $user, CmsPage $cmsPage, ?string $resourceClass = null): bool
    {
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'viewAny', $cmsPage);
        }
        return $user->can('view_cms::page');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param ?string $resourceClass
     * @return bool
     */
    public function create(User $user, ?string $resourceClass = null): bool
    {
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'create', null);
        }
        return $user->can('create_cms::page');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CmsPage  $cmsPage
     * @param ?string $resourceClass
     * @return bool
     */
    public function update(User $user, CmsPage $cmsPage, ?string $resourceClass = null): bool
    {
        if ($cmsPage->isDocumentPage())
        {
            return false;
        }
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'update', $cmsPage);
        }
        return $user->can('update_cms::page');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CmsPage  $cmsPage
     * @param ?string $resourceClass
     * @return bool
     */
    public function delete(User $user, CmsPage $cmsPage, ?string $resourceClass = null): bool
    {
        if ($cmsPage->isDocumentPage())
        {
            return false;
        }
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'delete', $cmsPage);
        }
        return $user->can('delete_cms::page');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @param ?string $resourceClass
     * @return bool
     */
    public function deleteAny(User $user, ?string $resourceClass = null): bool
    {
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'deleteAny', null);
        }
        return $user->can('delete_any_cms::page');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CmsPage  $cmsPage
     * @param ?string $resourceClass
     * @return bool
     */
    public function forceDelete(User $user, CmsPage $cmsPage, ?string $resourceClass = null): bool
    {
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'forceDelete', $cmsPage);
        }
        return $user->can('force_delete_cms::page');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @param ?string $resourceClass
     * @return bool
     */
    public function forceDeleteAny(User $user, ?string $resourceClass = null): bool
    {
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'forceDelete', null);
        }
        return $user->can('force_delete_any_cms::page');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CmsPage  $cmsPage
     * @param ?string $resourceClass
     * @return bool
     */
    public function restore(User $user, CmsPage $cmsPage, ?string $resourceClass = null): bool
    {
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'restore', $cmsPage);
        }
        return $user->can('restore_cms::page');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @param ?string $resourceClass
     * @return bool
     */
    public function restoreAny(User $user, ?string $resourceClass = null): bool
    {
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'restoreAny', null);
        }
        return $user->can('restore_any_cms::page');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CmsPage  $cmsPage
     * @param ?string $resourceClass
     * @return bool
     */
    public function replicate(User $user, CmsPage $cmsPage, ?string $resourceClass = null): bool
    {
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'replicate', $cmsPage);
        }
        return $user->can('replicate_cms::page');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @param ?string $resourceClass
     * @return bool
     */
    public function reorder(User $user, ?string $resourceClass = null): bool
    {
        if (! $this->isNormalPageResource($resourceClass)) {
            return $this->authorizeCmsPageClass($user, $resourceClass, 'reorder', null);
        }
        return $user->can('reorder_cms::page');
    }

    /**
     * Determine whether the user can publish.
     *
     * @param  \App\Models\User  $user
     * @param  null|\App\Models\CmsPage $cmsPage
     * @param null|string $resourceClass
     * @return bool
     */
    public function publish(User $user, ?CmsPage $cmsPage, ?string $resourceClass = null): bool
    {
        return $user->hasAnyPermission('publish');
        // if (! $this->isNormalPageResource($resourceClass)) {
        //     return $this->authorizeCmsPageClass($user, $resourceClass, 'publish', $cmsPage);
        // }
        // return $user->can('publish_cms::page');
    }

    /**
     * Determine whether the user can unpublish.
     *
     * @param  \App\Models\User  $user
     * @param  null|\App\Models\CmsPage $cmsPage
     * @param null|string $resourceClass
     * @return bool
     */
    public function unpublish(User $user, ?CmsPage $cmsPage, ?string $resourceClass = null): bool
    {
        return $user->hasAnyPermission('unpublish');
        // if (! $this->isNormalPageResource($resourceClass)) {
        //     return $this->authorizeCmsPageClass($user, $resourceClass, 'unpublish', $cmsPage);
        // }
        // return $user->can('unpublish_cms::page');
    }

    /**
     * Determine whether the user can schedule publish.
     *
     * @param  \App\Models\User  $user
     * @param  null|\App\Models\CmsPage $cmsPage
     * @param null|string $resourceClass
     * @return bool
     */
    public function schedulePublish(User $user, ?CmsPage $cmsPage, ?string $resourceClass = null): bool
    {
        return $user->hasAnyPermission('schedulePublish');
        // if (! $this->isNormalPageResource($resourceClass)) {
        //     return $this->authorizeCmsPageClass($user, $resourceClass, 'schedulePublish', $cmsPage);
        // }
        // return $user->can('schedule_publish_cms::page');
    }

    public function audit(User $user, $cmsPage, $pageClass = null, $resourceClass = null)
    {
        return $user->hasAnyPermission([
            // 'audit_cms::page',
            'audit',
        ]);
    }

    public function rollbackAudit(User $user, $cmsPage, $pageClass = null, $resourceClass = null)
    {
        return $user->hasAnyPermission([
            // 'audit_rollback_cms::page',
            'rollbackAudit',
        ]);
    }
}
