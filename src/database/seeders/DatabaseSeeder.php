<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        collect($this->getCustomPermissions())->each(fn ($permission) => Permission::findOrCreate($permission));

        $demoUserRoles = $this->createDemoUserRoles();

        /** @var ?User */
        $demoUser = User::query()->firstWhere('email', 'demo@solutionforest.net');

        if ($demoUser) {
            $demoUser->assignRole($demoUserRoles);
        }
    }

    private function createDemoUserRoles(): array
    {
        return collect($this->getRolePermissions())
            ->filter(fn ($permissions, $roleName) => in_array($roleName, [
                'guest',
            ]))
            ->each(fn ($permissions, $roleName) => Role::findOrCreate($roleName)->syncPermissions($permissions))
            ->keys()
            ->toArray();
    }

    private function getRolePermissions(): array 
    {
        return [
            'guest' => Permission::query()
                ->whereNotIn('name', [
                    // 'create_shield::role',
                    'delete_shield::role',
                    'delete_any_shield::role',
                    'view_content::type::document',
                    'view_any_content::type::document',
                    'create_content::type::document',
                    'update_content::type::document',
                    'restore_content::type::document',
                    'restore_any_content::type::document',
                    'replicate_content::type::document',
                    'reorder_content::type::document',
                    'delete_content::type::document',
                    'delete_any_content::type::document',
                    'force_delete_content::type::document',
                    'force_delete_any_content::type::document',
                ])
                ->pluck('name')->toArray(),
        ];
    }

    private function getCustomPermissions(): array
    {
        return [
            'publish',
            'unpublish',
            'schedulePublish',
            'audit',
            'rollbackAudit',
        ];
    }
}
