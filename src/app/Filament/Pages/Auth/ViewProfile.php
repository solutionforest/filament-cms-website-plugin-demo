<?php

namespace App\Filament\Pages\Auth;

use Exception;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\EditProfile as BasePage;
use Filament\Pages\Concerns;
use Filament\Pages\Page;
use Filament\Pages\SimplePage;
use Filament\Panel;
use Filament\Support\Enums\Alignment;
use Filament\Support\Exceptions\Halt;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

/**
 * @property Infolist $infolist
 */
class ViewProfile  extends SimplePage// extends BasePage
{
    use Concerns\HasRoutes;
    // use Concerns\InteractsWithFormActions;
    
    protected static string $view = 'filament.pages.auth.view-profile';

    protected static ?string $title = 'Profile';

    public static function getLabel(): string
    {
        return 'Profile';
        // return __('filament-panels::pages/auth/edit-profile.label');
    }

    public static function routes(Panel $panel): void
    {
        $slug = static::getSlug();

        Route::get("/{$slug}", static::class)
            ->middleware(static::getRouteMiddleware($panel))
            ->withoutMiddleware(static::getWithoutRouteMiddleware($panel))
            ->name('profile');
    }

    public static function getSlug(): string
    {
        return 'profile';
        // return static::$slug ?? (string) str(class_basename(static::class))
        //     ->kebab()
        //     ->slug();
    }

    /**
     * @return string | array<string>
     */
    public static function getRouteMiddleware(Panel $panel): string | array
    {
        return [
            ...(static::isEmailVerificationRequired($panel) ? [static::getEmailVerifiedMiddleware($panel)] : []),
            ...Arr::wrap(static::$routeMiddleware),
        ];
    }

    public function mount(): void
    {
        $this->fillInfolist();
    }

    public function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();

        if (! $user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }

        return $user;
    }

    public function hasLogo(): bool
    {
        return false;
    }

    public function fillInfolist()
    {
        // $data = $this->getUser()->attributesToArray();

        $this->callHook('beforeFill');

        // $data = $this->mutateFormDataBeforeFill($data);

        $this->infolist = $this->makeInfolist()
            ->schema($this->getInfolistSchema())
            ->record($this->getUser())
            ->columns(['default' => 1]);

        $this->callHook('afterFill');
    }

    public function getInfolistSchema(): array
    {
        return [
            Infolists\Components\TextEntry::make('name'),
            Infolists\Components\TextEntry::make('email'),
            Infolists\Components\TextEntry::make('roles.name')
                ->badge()
                ->formatStateUsing(fn ($state) => $state ? Str::headline($state) : ''),
        ];
    }

    public function backAction(): Action
    {
        return Action::make('back')
            ->label('Back')
            ->url(filament()->getUrl())
            ->color('gray');
    }
}
