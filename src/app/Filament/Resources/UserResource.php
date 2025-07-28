<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use App\Filament\Resources\Shield\RoleResource;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Support\Utils as SupportUtils;
use Closure;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SolutionForest\FilamentCms\Support\Utils;

class UserResource extends Resource 
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'User Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('name')->required(),
                    TextInput::make('email')->unique(ignoreRecord: true)->required(),
                    static::getPasswordField(),
                ])->columnSpanFull()->columns(['default' => 1]),

                static::getRoleGroupField(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                // Tables\Actions\BulkActionGroup::make([
                    DeleteBulkAction::make(),
                // ]),
            ])
            ->checkIfRecordIsSelectableUsing(fn (User $record) => static::canDelete($record));
    }
    
    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getPasswordField(): Component
    {
        return Group::make()
        ->hiddenOn('view')
        ->columns(2)
        ->schema([
            ... static::getPasswordSchema(),
        ]);
    }

    public static function getPasswordSchema(): array
    {
        return [
            TextInput::make('password')
                ->password()
                ->confirmed()
                ->dehydrateStateUsing(fn ($state) => ! empty($state) ? Hash::make($state) : '')
                ->required(),
            TextInput::make('password_confirmation')
                ->password()
                ->required(),
        ];
    }

    public static function getRoleGroupField(): Component
    {
        return Group::make([
            Section::make()
                ->hidden(fn (?User $record) => $record && $record->isSuperAdmin() && ! (Filament::auth()->user()?->isSuperAdmin() ?? false))
                ->schema([
                    Select::make('roles')
                        ->multiple()
                        ->relationship(
                            'roles', 
                            'name', 
                            fn (Builder $query) => $query->when(! (Filament::auth()->user()?->isSuperAdmin() ?? false), fn (Builder $query) => $query
                            ->whereNot('name', SupportUtils::getSuperAdminName()))
                        )
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record ? Str::headline($record->name) : null)
                        ->searchable(['name'])
                        ->preload()
                        ->live()
                        // ->afterStateUpdated(function ($))
                        ,
                ]),
        ])->columnSpanFull();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament-shield::filament-shield.nav.group');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationSort(): ?int
    {
        return -1;
    }
}
