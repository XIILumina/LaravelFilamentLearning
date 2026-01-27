<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GameHub - Your Gaming Community</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-zinc-950 text-zinc-100">
        <!-- Mobile-First Navigation -->
        <nav class="fixed w-full top-0 z-50 bg-zinc-950/95 backdrop-blur-md border-b border-zinc-800/50">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-lg shadow-orange-500/20">
                            <span class="text-white text-lg">🎮</span>
                        </div>
                        <span class="font-bold text-xl text-white hidden sm:block">GameHub</span>
                    </a>

                    <!-- Desktop Nav Links -->
                    <div class="hidden md:flex items-center gap-6">
                        <a href="{{ route('games.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Trending</a>
                        <a href="{{ route('communities.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Communities</a>
                        <a href="{{ route('blog.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors">Blog</a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center gap-2">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ url('/admin') }}" class="hidden sm:inline-flex text-xs font-medium px-3 py-1.5 rounded-lg border border-orange-500/50 text-orange-400 hover:bg-orange-500/10 transition-colors">
                                    Admin
                                </a>
                            @endif
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium px-4 py-2 rounded-xl bg-orange-500 text-white hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/25">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-zinc-400 hover:text-white transition-colors px-3 py-2">
                                Log In
                            </a>
                            <a href="{{ route('register') }}" class="text-sm font-medium px-4 py-2 rounded-xl bg-orange-500 text-white hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/25">
                                Sign Up
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="pt-24 pb-16 px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    Your Gaming
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Community</span>
                </h1>
                <p class="text-lg text-zinc-400 max-w-xl mx-auto mb-8 leading-relaxed">
                    Join passionate gamers, discover new titles, and share your gaming experiences.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('communities.index') }}" class="px-8 py-3 rounded-xl bg-orange-500 text-white font-medium hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40">
                        Explore!
                    </a>
                    <a href="{{ route('games.index') }}" class="px-8 py-3 rounded-xl border border-zinc-700 text-zinc-300 font-medium hover:border-zinc-500 hover:text-white transition-colors">
                        Trending Games
                    </a>
                </div>
            </div>
        </section>

        <!-- Stats Bar -->
        <section class="border-y border-zinc-800/50 bg-zinc-900/30">
            <div class="max-w-4xl mx-auto px-4 py-8">
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-white">{{ number_format(\App\Models\Community::count()) }}</div>
                        <p class="text-xs sm:text-sm text-zinc-500 mt-1">Communities</p>
                    </div>
                    <div class="text-center border-x border-zinc-800/50">
                        <div class="text-2xl sm:text-3xl font-bold text-white">{{ number_format(\App\Models\Game::count()) }}</div>
                        <p class="text-xs sm:text-sm text-zinc-500 mt-1">Games</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-white">{{ number_format(\App\Models\User::count()) }}</div>
                        <p class="text-xs sm:text-sm text-zinc-500 mt-1">Members</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Games -->
        <section class="py-12 px-4">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-white">Popular Games</h2>
                    <a href="{{ route('games.index') }}" class="text-sm text-orange-500 hover:text-orange-400 font-medium">
                        View All →
                    </a>
                </div>

                @php
                    $featuredGames = \App\Models\Game::with(['developer', 'genres'])
                        ->orderByDesc('rating')
                        ->limit(6)
                        ->get();
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                    @foreach($featuredGames as $game)
                        <a href="{{ route('games.show', $game) }}" class="group">
                            <div class="aspect-[3/4] rounded-xl overflow-hidden bg-zinc-800 mb-2">
                                @if($game->image_url)
                                    <img src="{{ asset('storage/' . $game->image_url) }}" 
                                         alt="{{ $game->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-4xl opacity-30">🎮</div>
                                @endif
                            </div>
                            <h3 class="text-sm font-medium text-white group-hover:text-orange-400 transition-colors line-clamp-1">{{ $game->title }}</h3>
                            <div class="flex items-center gap-1 mt-1">
                                <span class="text-yellow-500 text-xs">★</span>
                                <span class="text-xs text-zinc-400">{{ number_format((float)($game->rating ?? 0), 1) }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Trending Communities -->
        <section class="py-12 px-4 bg-zinc-900/30">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-white">Trending Communities</h2>
                    <a href="{{ route('communities.index') }}" class="text-sm text-orange-500 hover:text-orange-400 font-medium">
                        View All →
                    </a>
                </div>

                @php
                    $trendingCommunities = \App\Models\Community::with('game')
                        ->orderByDesc('subscriber_count')
                        ->limit(4)
                        ->get();
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($trendingCommunities as $community)
                        <a href="{{ route('communities.show', $community) }}" class="block p-4 bg-zinc-800/50 border border-zinc-700/50 rounded-2xl hover:border-zinc-600 transition-all group">
                            <div class="flex items-center gap-3 mb-3">
                                @if($community->icon_url)
                                    <img src="{{ $community->icon_url }}" class="w-12 h-12 rounded-xl object-cover" alt="">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-xl">🎮</div>
                                @endif
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-white group-hover:text-orange-400 transition-colors truncate">{{ $community->name }}</h3>
                                    <p class="text-xs text-zinc-500">{{ number_format($community->subscriber_count) }} members</p>
                                </div>
                            </div>
                            @if($community->description)
                                <p class="text-sm text-zinc-400 line-clamp-2">{{ $community->description }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Recent Discussions -->
        <section class="py-12 px-4">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-white">Recent Discussions</h2>
                </div>

                @php
                    $recentPosts = \App\Models\Post::with(['user', 'community'])
                        ->whereHas('community')
                        ->orderByDesc('created_at')
                        ->limit(5)
                        ->get();
                @endphp

                <div class="space-y-3">
                    @forelse($recentPosts as $post)
                        <a href="{{ route('communities.post', [$post->community, $post]) }}" 
                           class="block p-4 bg-zinc-900/50 border border-zinc-800/50 rounded-xl hover:border-zinc-700 transition-all group">
                            <div class="flex items-start gap-3">
                                <div class="hidden sm:flex flex-col items-center gap-1 text-zinc-500 text-sm min-w-[50px]">
                                    <span class="font-semibold text-white">{{ $post->likes_count ?? 0 }}</span>
                                    <span class="text-xs">votes</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-white group-hover:text-orange-400 transition-colors line-clamp-1 mb-1">
                                        {{ $post->title }}
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-zinc-500">
                                        <span class="text-orange-400 font-medium">{{ $post->community->hashtag }}</span>
                                        <span class="hidden sm:inline">•</span>
                                        <span class="hidden sm:inline">by {{ $post->user->name }}</span>
                                        <span>•</span>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                        <span>•</span>
                                        <span>{{ $post->comments_count ?? 0 }} comments</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-12 text-zinc-500">
                            <p>No discussions yet. Be the first to start one!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 px-4 bg-gradient-to-b from-zinc-900/50 to-zinc-950">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4">Ready to join?</h2>
                <p class="text-zinc-400 mb-6">Create your account and become part of the community.</p>
                @guest
                    <a href="{{ route('register') }}" class="inline-block px-8 py-3 rounded-xl bg-orange-500 text-white font-medium hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/25">
                        Get Started Free
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="inline-block px-8 py-3 rounded-xl bg-orange-500 text-white font-medium hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/25">
                        Go to Dashboard
                    </a>
                @endguest
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-zinc-800/50 py-8 px-4">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-sm">🎮</div>
                        <span class="font-semibold text-white">GameHub</span>
                    </div>
                    <div class="flex items-center gap-6 text-sm text-zinc-500">
                        <a href="{{ route('games.index') }}" class="hover:text-white transition-colors">Games</a>
                        <a href="{{ route('communities.index') }}" class="hover:text-white transition-colors">Communities</a>
                        <a href="{{ route('contact.index') }}" class="hover:text-white transition-colors">Contact</a>
                    </div>
                    <p class="text-xs text-zinc-600">© {{ date('Y') }} GameHub</p>
                </div>
            </div>
        </footer>

        <!-- Mobile Bottom Nav -->
        <nav class="fixed bottom-0 left-0 right-0 bg-zinc-900/95 backdrop-blur-md border-t border-zinc-800/50 md:hidden z-50">
            <div class="flex justify-around items-center h-16 px-2">
                <a href="/" class="flex flex-col items-center gap-1 text-orange-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <span class="text-[10px]">Home</span>
                </a>
                <a href="{{ route('games.index') }}" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4z"/>
                    </svg>
                    <span class="text-[10px]">Games</span>
                </a>
                <a href="{{ route('communities.index') }}" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                    <span class="text-[10px]">Communities</span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[10px]">Profile</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-[10px]">Login</span>
                    </a>
                @endauth
            </div>
        </nav>
        <div class="h-16 md:hidden"></div>
    </body>
</html>
