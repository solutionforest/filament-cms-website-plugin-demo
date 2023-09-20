<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Shield\RoleResource;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Support\Utils as SupportUtils;
use Closure;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
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

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    Forms\Components\TextInput::make('name')->required(),
                    Forms\Components\TextInput::make('email')->unique(ignoreRecord: true)->required(),
                    static::getPasswordField(),
                ])->columnSpanFull()->columns(['default' => 1]),

                static::getRoleGroupField(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->checkIfRecordIsSelectableUsing(fn (User $record) => static::canDelete($record));
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getPasswordField(): Forms\Components\Component
    {
        return Forms\Components\Group::make()
        ->hiddenOn('view')
        ->columns(2)
        ->schema([
            ... static::getPasswordSchema(),
        ]);
    }

    public static function getPasswordSchema(): array
    {
        return [
            Forms\Components\TextInput::make('password')
                ->password()
                ->confirmed()
                ->dehydrateStateUsing(fn ($state) => ! empty($state) ? Hash::make($state) : '')
                ->required(),
            Forms\Components\TextInput::make('password_confirmation')
                ->password()
                ->required(),
        ];
    }

    public static function getRoleGroupField(): Forms\Components\Component
    {
        return Forms\Components\Group::make([
            Forms\Components\Card::make()
                ->hidden(fn (?User $record) => $record && $record->isSuperAdmin() && ! (Filament::auth()->user()?->isSuperAdmin() ?? false))
                ->schema([
                    Forms\Components\Select::make('roles')
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
