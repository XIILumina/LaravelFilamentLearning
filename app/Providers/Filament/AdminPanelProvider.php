<?php

namespace App\Providers\Filament;

use App\Filament\Resources\AppObjectResource;
use App\Filament\Resources\AttributeResource;
use App\Filament\Resources\AttributeValueResource;
use App\Filament\Resources\CommentResource;
use App\Filament\Resources\CommunityResource;
use App\Filament\Resources\ContactResource;
use App\Filament\Resources\DeveloperResource;
use App\Filament\Resources\GameResource;
use App\Filament\Resources\GenreResource;
use App\Filament\Resources\PlatformResource;
use App\Filament\Resources\PostResource;
use App\Filament\Resources\WishlistResource;
use App\Http\Middleware\IsAdmin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->resources([
                // PIM System
                AttributeResource::class,
                AttributeValueResource::class,
                AppObjectResource::class,
                // Games & Catalog
                GameResource::class,
                GenreResource::class,
                PlatformResource::class,
                DeveloperResource::class,
                // Content
                PostResource::class,
                CommentResource::class,
                CommunityResource::class,
                // Users
                WishlistResource::class,
                ContactResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
                IsAdmin::class,
            ]);
    }
}
