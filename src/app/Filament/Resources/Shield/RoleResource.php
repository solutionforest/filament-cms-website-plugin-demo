<?php

namespace App\Filament\Resources\Shield;

use App\Filament\Resources\Shield\RoleResource\Pages;
use App\Filament\Resources\Shield\RoleResource\Pages\CreateRole;
use App\Filament\Resources\Shield\RoleResource\Pages\EditRole;
use App\Filament\Resources\Shield\RoleResource\Pages\ListRoles;
use App\Filament\Resources\Shield\RoleResource\Pages\ViewRole;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BezhanSalleh\FilamentShield\Forms\ShieldSelectAllToggle;
use BezhanSalleh\FilamentShield\Resources\RoleResource as BaseRoleResource;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class RoleResource extends BaseRoleResource implements HasShieldPermissions
{
    protected static ?string $recordTitleAttribute = 'name';

    // ---
    // Custom on demo Start
    // ---
    private static function customLockedSuffixPermissions($operation = null): array
    {
        if ($operation === 'create') {
            return [
                // 'content::type::document',
                'delete_shield::role',
                'delete_any_shield::role',
            ];
        }
        return [
            'shield::role',
            'cms::page',
            // 'content::type::document',
        ];
    }

    /**
     * Disable checkbox to avoid update
     */
    private static function disableResourceEntityOnUser($permission, ?string $operation)
    {
        $user = Filament::auth()->user();

        if ($user?->isSuperAdmin() ?? false) {
            return false;
        }

        $lockedPermission = static::customLockedSuffixPermissions($operation);

        return Str::endsWith($permission, $lockedPermission);
    }

    private static function enableSelectAllButton(): bool
    {
        $user = Filament::auth()->user();

        if ($user?->isSuperAdmin() ?? false) {
            return true;
        }

        return false;
    }

    private static function disableBulkToggleableOnUser(Component $component): bool
    {
        $user = Filament::auth()->user();

        if ($user?->isSuperAdmin() ?? false) {
            return false;
        }

        $lockedPermission = array_unique(array_merge(
            static::customLockedSuffixPermissions('create'),
            static::customLockedSuffixPermissions('edit'),
        ));

        return Str::endsWith($component->getStatePath(false), $lockedPermission);
    }
    // ---
    // Custom on demo End
    // ---

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view' => ViewRole::route('/{record}'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    public static function getSelectAllFormComponent(): Component
    {
        return parent::getSelectAllFormComponent()
            // custom
            ->disabled(fn () => ! static::enableSelectAllButton());
    }

    public static function getCheckboxListFormComponent(string $name, array $options, bool $searchable = true, array | int | string | null $columns = null, array | int | string | null $columnSpan = null): Component
    {
        return parent::getCheckboxListFormComponent(
            name: $name,
            options: $options,
            searchable: $searchable,
            columns: $columns,
            columnSpan: $columnSpan
        )
            // custom
            ->disableOptionWhen(fn ($value, $operation) => static::disableResourceEntityOnUser($value, $operation))
            ->bulkToggleable(fn ($component) => !static::disableBulkToggleableOnUser($component));
    }
}
