<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('Konveksi Bandung 48')
            ->brandLogo(fn () => view('filament.custom.brand-logo'))
            ->brandLogoHeight('2rem')
            ->favicon(asset('images/konveksi_bandung_48.png'))
            ->login(\App\Filament\Pages\Auth\Login::class)
            ->profile(EditProfile::class)
            ->userMenuItems([
                'profile' => MenuItem::make()
                ->label(fn() => auth()->user()->name) 
                ->icon('heroicon-m-user-circle'),
            ])
            ->renderHook(
                PanelsRenderHook::USER_MENU_AFTER, 
                fn (): \Illuminate\Support\HtmlString => new \Illuminate\Support\HtmlString('
                    <div class="flex flex-col items-start justify-center ml-1 leading-tight hidden sm:flex border-l border-gray-200 dark:border-gray-700 pl-3">
                        <span class="text-sm font-bold text-gray-900 dark:text-white">' . auth()->user()->name . '</span>
                        <span class="text-xs text-gray-500 uppercase tracking-wider">' . (auth()->user()->employee->job_desk ?? 'Administrator') . '</span>
                    </div>
                '),
            )
            ->renderHook(
                PanelsRenderHook::PAGE_START, 
                fn () => view('filament.custom.dashboard-responsive')
            )
            ->databaseNotifications()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k']) // Field Search
            ->sidebarCollapsibleOnDesktop()
            ->databaseNotificationsPolling('25s')
            ->colors([
                'primary' => Color::Amber,
                'purple' => Color::Purple,
                'emerald' => Color::Emerald,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\OrderChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
