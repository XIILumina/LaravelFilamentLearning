<!-- Notifications Dropdown -->
<div x-data="{ open: false, buttonRect: null }" class="relative" @click.away="open = false">
    <button @click="open = !open; buttonRect = $el.getBoundingClientRect()" class="relative p-2 text-zinc-400 hover:text-white rounded-lg hover:bg-zinc-800 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @php
            $unreadCount = auth()->user()->getUnreadNotificationCount();
        @endphp
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 flex h-5 w-5 items-center justify-center rounded-full bg-orange-600 text-white text-xs font-bold">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed w-96 origin-top-left rounded-lg bg-zinc-900 shadow-xl ring-1 ring-zinc-800 z-[100]"
         :style="buttonRect ? `top: ${buttonRect.bottom + 8}px; left: ${buttonRect.left}px;` : 'display: none;'"
         style="display: none;">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-800">
            <h3 class="text-lg font-semibold text-white">Notifications</h3>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-orange-500 hover:text-orange-400">Mark all read</button>
                </form>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @php
                $recentNotifications = auth()->user()->notifications()->take(10)->get();
                $activeAnnouncements = \App\Models\Announcement::active()->take(3)->get();
            @endphp

            <!-- Announcements Section -->
            @if($activeAnnouncements->count() > 0)
                <div class="px-4 py-2 bg-orange-900/20 border-b border-zinc-800">
                    <p class="text-xs font-semibold text-orange-400 uppercase tracking-wider">Announcements</p>
                </div>
                @foreach($activeAnnouncements as $announcement)
                    <a href="{{ route('inbox.index') }}" class="block px-4 py-3 hover:bg-zinc-800 transition-colors border-b border-zinc-800/50">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white line-clamp-1">{{ $announcement->title }}</p>
                                <p class="text-xs text-zinc-400 mt-0.5">{{ $announcement->published_at?->diffForHumans() ?? $announcement->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif

            <!-- Personal Notifications -->
            @if($recentNotifications->count() > 0)
                <div class="px-4 py-2 bg-zinc-800/50 border-b border-zinc-800">
                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider">Recent Activity</p>
                </div>
                @foreach($recentNotifications as $notification)
                    <a href="{{ $notification->link ?? route('inbox.index') }}" 
                       class="block px-4 py-3 hover:bg-zinc-800 transition-colors border-b border-zinc-800/50 {{ !$notification->is_read ? 'bg-zinc-850/50' : '' }}">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                @if($notification->type === 'mention')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                @elseif($notification->type === 'message')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-white line-clamp-2 {{ !$notification->is_read ? 'font-semibold' : '' }}">
                                    {{ $notification->message }}
                                </p>
                                <p class="text-xs text-zinc-500 mt-0.5">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            @if(!$notification->is_read)
                                <div class="flex-shrink-0">
                                    <span class="flex h-2 w-2 rounded-full bg-orange-500"></span>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            @else
                <div class="px-4 py-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-zinc-700 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="text-sm text-zinc-500">No notifications yet</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 bg-zinc-850 border-t border-zinc-800 rounded-b-lg">
            <a href="{{ route('inbox.index') }}" class="text-sm text-orange-500 hover:text-orange-400 font-medium">
                View all notifications →
            </a>
        </div>
    </div>
</div>
