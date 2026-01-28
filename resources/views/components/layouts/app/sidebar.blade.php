<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
        <flux:sidebar sticky stashable class="border-e border-zinc-300 bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-900 z-[60]">
            <flux:sidebar.toggle class="lg:hidden text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse py-3 px-2 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-colors" wire:navigate>
                <x-app-logo />
            </a>

            <!-- Quick Action Buttons -->
            <div class="flex items-center gap-2 px-2 mb-4">
                <x-messages-dropdown />
                <x-notification-dropdown />
            </div>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Navigation')" class="grid">
                    <flux:navlist.item 
                        icon="squares-2x2" 
                        :href="route('dashboard')" 
                        :current="request()->routeIs('dashboard')" 
                        wire:navigate
                        class="text-zinc-700 dark:text-zinc-300"
                    >{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item 
                        icon="fire" 
                        :href="route('trending.index')" 
                        :current="request()->routeIs('trending.*')" 
                        wire:navigate
                        class="text-zinc-700 dark:text-zinc-300"
                    >{{ __('Trending') }}</flux:navlist.item>
                    <flux:navlist.item 
                        icon="tag" 
                        :href="route('genres.index')" 
                        :current="request()->routeIs('genres.*')" 
                        wire:navigate
                        class="text-zinc-700 dark:text-zinc-300"
                    >{{ __('Genres') }}</flux:navlist.item>
                </flux:navlist.group>
                
                <flux:navlist.group :heading="__('Community')" class="grid">
                    <flux:navlist.item 
                        icon="chat-bubble-left-ellipsis" 
                        :href="route('blog.index')" 
                        :current="request()->routeIs('blog.*')" 
                        wire:navigate
                        class="text-zinc-700 dark:text-zinc-300"
                    >{{ __('Blog') }}</flux:navlist.item>
                    <flux:navlist.item 
                        icon="user-group" 
                        :href="route('communities.index')" 
                        :current="request()->routeIs('communities.*')" 
                        wire:navigate
                        class="text-zinc-700 dark:text-zinc-300"
                    >{{ __('Communities') }}</flux:navlist.item>
                    <flux:navlist.item 
                        icon="users" 
                        :href="route('connections.index')" 
                        :current="request()->routeIs('connections.*')" 
                        wire:navigate
                        class="text-zinc-700 dark:text-zinc-300"
                    >
                        <span>{{ __('Connections') }}</span>
                        @php
                            $pendingCount = auth()->user()->pendingFriendRequests()->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="ml-auto bg-green-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </flux:navlist.item>
                    <flux:navlist.item 
                        icon="user-circle" 
                        :href="route('profile.show')" 
                        :current="request()->routeIs('profile.show') || request()->routeIs('user.profile')" 
                        wire:navigate
                        class="text-zinc-700 dark:text-zinc-300"
                    >{{ __('Profile') }}</flux:navlist.item>
                    <flux:navlist.item 
                        icon="envelope" 
                        :href="route('messages.index')" 
                        :current="request()->routeIs('messages.*')" 
                        wire:navigate
                        class="text-zinc-700 dark:text-zinc-300"
                    >{{ __('Messages') }}</flux:navlist.item>
                    <flux:navlist.item 
                        icon="bell" 
                        :href="route('inbox.index')" 
                        :current="request()->routeIs('inbox.*')" 
                        wire:navigate
                        class="text-zinc-700 dark:text-zinc-300"
                    >
                        <span>{{ __('Inbox') }}</span>
                        @if(auth()->user()->getUnreadNotificationCount() > 0)
                            <span class="ml-auto bg-orange-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                                {{ auth()->user()->getUnreadNotificationCount() }}
                            </span>
                        @endif
                    </flux:navlist.item>
                    <flux:navlist.item 
                        icon="paper-airplane" 
                        :href="route('contact.index')" 
                        :current="request()->routeIs('contact.*')" 
                        wire:navigate
                        class="text-zinc-700 dark:text-zinc-300"
                    >{{ __('Contact') }}</flux:navlist.item>
                </flux:navlist.group>

                @if(auth()->user()->isAdmin())
                <flux:navlist.group :heading="__('Admin')" class="grid">
                    <flux:navlist.item 
                        icon="rectangle-group" 
                        :href="url('/admin')" 
                        :current="request()->is('admin*')" 
                        class="text-zinc-700 dark:text-zinc-300"
                    >{{ __('Admin Panel') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                    class="text-zinc-700 dark:text-zinc-300"
                />

                <flux:menu class="w-[220px] bg-zinc-100 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-zinc-300 text-zinc-900 dark:bg-zinc-700 dark:text-zinc-100 font-semibold"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs text-zinc-600 dark:text-zinc-400">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator class="bg-zinc-300 dark:bg-zinc-700" />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.show')" icon="user-circle" wire:navigate class="text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700">{{ __('Profile') }}</flux:menu.item>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate class="text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700">{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator class="bg-zinc-300 dark:bg-zinc-700" />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden bg-zinc-100 dark:bg-zinc-900 border-b border-zinc-300 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200" icon="bars-2" inset="left" />

            <flux:spacer />

            <!-- Mobile Quick Actions -->
            <div class="flex items-center gap-2 mr-2">
                <x-messages-dropdown />
                <x-notification-dropdown />
            </div>

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                    class="text-zinc-700 dark:text-zinc-300"
                />

                <flux:menu class="bg-zinc-100 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-zinc-300 text-zinc-900 dark:bg-zinc-700 dark:text-zinc-100 font-semibold"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs text-zinc-600 dark:text-zinc-400">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator class="bg-zinc-300 dark:bg-zinc-700" />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.show')" icon="user-circle" wire:navigate class="text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700">{{ __('Profile') }}</flux:menu.item>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate class="text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700">{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator class="bg-zinc-300 dark:bg-zinc-700" />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        <x-prevent-double-submit />

        @fluxScripts
    </body>
</html>
