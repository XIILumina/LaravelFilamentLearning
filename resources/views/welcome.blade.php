<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameHub — Datu Portāls</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet"/>
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #fff; color: #222; font-family: Arial, Helvetica, sans-serif; font-size: 13.5px; line-height: 1.4; }

        /*  Top bar  */
        .w-topbar { background: #003399; border-bottom: 2px solid #0022aa; }
        .w-topbar-inner { max-width: 1280px; margin: 0 auto; padding: 6px 16px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .w-badge { background: #fff; color: #003399; font-size: 10px; font-weight: bold; padding: 2px 6px; letter-spacing: 1px; flex-shrink: 0; }
        .w-topbar-title { font-size: 13px; font-weight: bold; color: #fff; flex: 1; text-decoration: none; }
        .w-topbar-right { font-size: 12px; color: #cce; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .w-topbar-link { color: #adf; text-decoration: underline; }
        .w-topbar-sep { color: #557; }

        /*  Nav row  */
        .w-nav { background: #f0f4ff; border-bottom: 1px solid #c8d4ee; }
        .w-nav-inner { max-width: 1280px; margin: 0 auto; padding: 0 16px; display: flex; align-items: center; gap: 0; flex-wrap: wrap; }
        .w-nav-link { display: inline-block; padding: 8px 14px; font-size: 12.5px; color: #003399; text-decoration: none; border-right: 1px solid #d0d8f0; font-weight: bold; }
        .w-nav-link:first-child { border-left: 1px solid #d0d8f0; }
        .w-nav-link:hover { background: #e0e8ff; color: #001188; }

        /*  Hero  */
        .w-hero { background: #eef2ff; border-bottom: 1px solid #c8d4ee; padding: 12px 0; }
        .w-hero-inner { max-width: 1280px; margin: 0 auto; padding: 0 16px; }
        .w-hero-title { font-size: 18px; font-weight: bold; color: #003399; margin: 0 0 4px 0; }
        .w-hero-sub { font-size: 12.5px; color: #444; margin: 0; max-width: 820px; }

        /*  Main 2-col  */
        .w-main { max-width: 1280px; margin: 0 auto; padding: 14px 16px; display: grid; grid-template-columns: 1fr 270px; gap: 18px; align-items: start; }

        /*  Section box  */
        .w-section { border: 1px solid #c8c8c8; }
        .w-section + .w-section { margin-top: 1.25rem; }
        .w-sh { background: #003399; color: #fff; font-size: 11px; font-weight: bold; letter-spacing: 0.5px; padding: 5px 10px; display: flex; justify-content: space-between; align-items: center; }
        .w-sh-link { color: #adf; font-size: 10px; font-weight: normal; text-decoration: underline; }

        /*  Quick menu  */
        .w-qm { display: grid; grid-template-columns: 1fr 1fr; }
        .w-qi { display: block; padding: 9px 11px 8px; border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0; text-decoration: none; background: #fff; transition: background 0.1s; }
        .w-qi:nth-child(even) { border-right: none; }
        .w-qi:hover { background: #eef2ff; }
        .w-qi-title { font-size: 13px; font-weight: bold; color: #003399; margin-bottom: 3px; }
        .w-qi-desc { font-size: 11.5px; color: #444; line-height: 1.4; margin-bottom: 3px; }
        .w-qi-meta { font-size: 10.5px; color: #888; }

        /*  News  */
        .w-news { padding: 4px 0; }
        .w-ni { display: flex; gap: 10px; padding: 5px 10px; border-bottom: 1px dotted #e0e0e0; align-items: baseline; }
        .w-ni:last-child { border-bottom: none; }
        .w-nd { font-size: 11px; color: #666; white-space: nowrap; flex-shrink: 0; }
        .w-nl { font-size: 12.5px; color: #003399; text-decoration: underline; line-height: 1.4; }
        .w-nl:hover { color: #cc0000; }
        .w-news-empty { padding: 10px; font-size: 12px; color: #888; }

        /*  Right widgets  */
        .w-counter { padding: 14px 12px 12px; text-align: center; background: #f6f8ff; border-top: 1px solid #e0e0e0; }
        .w-cnt-num { font-size: 38px; font-weight: bold; color: #003399; line-height: 1; }
        .w-cnt-lbl { font-size: 10.5px; color: #666; margin: 4px 0 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .w-cnt-link { font-size: 11px; color: #003399; text-decoration: underline; font-weight: bold; }

        .w-stats { width: 100%; border-collapse: collapse; border-top: 1px solid #e0e0e0; }
        .w-stats tr:nth-child(even) { background: #f8f8f8; }
        .w-sl { padding: 5px 10px; font-size: 12px; color: #333; border-bottom: 1px solid #eee; }
        .w-sv { padding: 5px 10px; font-size: 13px; font-weight: bold; color: #003399; text-align: right; border-bottom: 1px solid #eee; white-space: nowrap; }

        .w-support { padding: 10px 12px; border-top: 1px solid #e0e0e0; }
        .w-sr { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; font-size: 12.5px; }
        .w-si { font-size: 14px; color: #003399; width: 16px; flex-shrink: 0; }
        .w-st { color: #444; }
        .w-btn { display: inline-block; background: #003399; color: #fff !important; font-size: 11.5px; font-weight: bold; padding: 5px 12px; text-decoration: none; border: 1px solid #002277; margin-top: 8px; }
        .w-btn:hover { background: #0044cc; }

        .w-about { padding: 10px 12px; border-top: 1px solid #e0e0e0; font-size: 12px; color: #444; }
        .w-about p { margin: 0 0 6px 0; }

        .w-link { color: #003399; text-decoration: underline; }
        .w-link:hover { color: #cc0000; }

        /*  Auth banner  */
        .w-auth { padding: 10px 12px; border-top: 1px solid #e0e0e0; background: #fff; display: flex; flex-direction: column; gap: 6px; }
        .w-auth-btn { display: block; text-align: center; padding: 6px 10px; font-size: 12px; font-weight: bold; text-decoration: none; border: 1px solid #003399; color: #003399; }
        .w-auth-btn:hover { background: #eef2ff; }
        .w-auth-btn.primary { background: #003399; color: #fff; border-color: #002277; }
        .w-auth-btn.primary:hover { background: #0044cc; }

        /*  Footer  */
        .w-footer { border-top: 2px solid #003399; background: #eef2ff; padding: 8px 0; margin-top: 0; }
        .w-fi { max-width: 1280px; margin: 0 auto; padding: 0 16px; display: flex; flex-wrap: wrap; align-items: center; gap: 6px; font-size: 11.5px; color: #444; }
        .w-fc { font-weight: bold; color: #003399; }
        .w-fs { color: #aaa; }
        .w-fl { color: #003399; text-decoration: underline; }
        .w-fl:hover { color: #cc0000; }

        /*  Responsive  */
        @media (max-width: 720px) {
            .w-main { grid-template-columns: 1fr; }
            .w-qm { grid-template-columns: 1fr; }
            .w-qi { border-right: none; }
            .w-right { order: -1; }
            .w-nav-link { padding: 7px 10px; font-size: 12px; }
        }
    </style>
</head>
<body>

@php
    $updatedDate = now()->format("d.m.Y");
    $totalGames  = \App\Models\Game::count();
    $totalUsers  = \App\Models\User::count();
    $totalComm   = \App\Models\Community::count();
    $totalPosts  = \App\Models\Post::count();
    $totalGenres = \App\Models\Genre::count();
    $totalPlat   = \App\Models\Platform::count();
    $totalDev    = \App\Models\Developer::count();
    $recentPosts = \App\Models\Post::latest()->limit(8)->get();
    $newGames    = \App\Models\Game::with("developer")->latest()->limit(5)->get();
@endphp

{{-- TOP BAR --}}
<div class="w-topbar">
    <div class="w-topbar-inner">
        <span class="w-badge">PORTĀLS</span>
        <a href="{{ route("home") }}" class="w-topbar-title">GameHub — Spēļu Datu Portāls</a>
        <div class="w-topbar-right">
            <span>Atjaunināts: <strong>{{ $updatedDate }}</strong></span>
            <span class="w-topbar-sep">|</span>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ url("/admin") }}" class="w-topbar-link">Admin</a>
                    <span class="w-topbar-sep">|</span>
                @endif
                <a href="{{ route("dashboard") }}" class="w-topbar-link">Mans profils</a>
            @else
                <a href="{{ route("login") }}" class="w-topbar-link">Pieslēgties</a>
                <span class="w-topbar-sep">|</span>
                <a href="{{ route("register") }}" class="w-topbar-link">Reģistrēties</a>
            @endauth
        </div>
    </div>
</div>

{{-- NAV ROW --}}
<div class="w-nav">
    <div class="w-nav-inner">
        <a href="{{ route("games.index") }}" class="w-nav-link">Spēles</a>
        <a href="{{ route("communities.index") }}" class="w-nav-link">Kopienas</a>
        <a href="{{ route("blog.index") }}" class="w-nav-link">Blogs</a>
        <a href="{{ route("trending.index") }}" class="w-nav-link">Tendences</a>
        <a href="{{ route("genres.index") }}" class="w-nav-link">Žanri</a>
        <a href="{{ route("platforms.index") }}" class="w-nav-link">Platformas</a>
        <a href="{{ route("contact.index") }}" class="w-nav-link">Kontakts</a>
    </div>
</div>

{{-- HERO --}}
<div class="w-hero">
    <div class="w-hero-inner">
        <h1 class="w-hero-title">Esi informēts! Atklāj jaunākās spēles, kopienas un tendences!</h1>
        <p class="w-hero-sub">Bezmaksas piekļuve spēļu katalogam, spēlētāju kopienām un rakstiem. Reģistrācijai nav nepieciešama maksa.</p>
    </div>
</div>

{{-- MAIN GRID --}}
<div class="w-main">

    {{-- LEFT --}}
    <div class="w-left">

        {{-- Quick Menu --}}
        <div class="w-section">
            <div class="w-sh">ĀTRĀ IZVĒLNE</div>
            <div class="w-qm">

                <a href="{{ route("games.index") }}" class="w-qi">
                    <div class="w-qi-title">Spēļu katalogs</div>
                    <div class="w-qi-desc">Visu reģistrēto spēļu saraksts ar vērtējumiem un informāciju</div>
                    <div class="w-qi-meta">Atjaunināts: {{ $updatedDate }}</div>
                </a>

                <a href="{{ route("communities.index") }}" class="w-qi">
                    <div class="w-qi-title">Kopienas</div>
                    <div class="w-qi-desc">Spēlētāju kopienas, diskusijas un biedru aktivitāte</div>
                    <div class="w-qi-meta">Atjaunināts: {{ $updatedDate }}</div>
                </a>

                <a href="{{ route("trending.index") }}" class="w-qi">
                    <div class="w-qi-title">Tendences</div>
                    <div class="w-qi-desc">Populārākās kopienas un aktīvākās diskusijas šobrīd</div>
                    <div class="w-qi-meta">Atjaunināts: {{ $updatedDate }}</div>
                </a>

                <a href="{{ route("blog.index") }}" class="w-qi">
                    <div class="w-qi-title">Blogs un raksti</div>
                    <div class="w-qi-desc">Diskusijas, atsauksmes un jaunumi no kopienas</div>
                    <div class="w-qi-meta">Atjaunināts: {{ $updatedDate }}</div>
                </a>

                <a href="{{ route("genres.index") }}" class="w-qi">
                    <div class="w-qi-title">Žanri un kategorijas</div>
                    <div class="w-qi-desc">Spēļu klasifikācija pēc žanriem un tematiem</div>
                    <div class="w-qi-meta">Atjaunināts: {{ $updatedDate }}</div>
                </a>

                <a href="{{ route("platforms.index") }}" class="w-qi">
                    <div class="w-qi-title">Platformas</div>
                    <div class="w-qi-desc">PC, konsoles un mobilās platformas ar spēļu katalogiem</div>
                    <div class="w-qi-meta">Atjaunināts: {{ $updatedDate }}</div>
                </a>

                <a href="{{ route("contact.index") }}" class="w-qi">
                    <div class="w-qi-title">Sazināties ar mums</div>
                    <div class="w-qi-desc">Atbalsts, ieteikumi un sadarbības pieprasījumi</div>
                    <div class="w-qi-meta">Pieejams: P–Pk 9:00–17:00</div>
                </a>

                @auth
                <a href="{{ route("dashboard") }}" class="w-qi">
                    <div class="w-qi-title">Mans profils</div>
                    <div class="w-qi-desc">Wishlist, ziņojumi, paziņojumi un iestatījumi</div>
                    <div class="w-qi-meta">Pieslēgts kā {{ auth()->user()->name }}</div>
                </a>
                @else
                <a href="{{ route("register") }}" class="w-qi">
                    <div class="w-qi-title">Reģistrēties</div>
                    <div class="w-qi-desc">Pievienojies kopienai — bezmaksas, bez ierobežojumiem</div>
                    <div class="w-qi-meta">Reģistrācija aizņem mazāk par minūti</div>
                </a>
                @endauth

            </div>
        </div>

        {{-- Latest discussions (blog posts) --}}
        <div class="w-section">
            <div class="w-sh">
                JAUNĀKĀS DISKUSIJAS
                <a href="{{ route("blog.index") }}" class="w-sh-link">VISAS &rsaquo;</a>
            </div>
            <div class="w-news">
                @forelse ($recentPosts as $post)
                    <div class="w-ni">
                        <span class="w-nd">{{ $post->created_at->format("d.m.Y") }}</span>
                        <a href="{{ route("blog.show", $post) }}" class="w-nl">
                            {{ $post->title ?? \Illuminate\Support\Str::limit($post->content ?? "Ieraksts #".$post->id, 80) }}
                        </a>
                    </div>
                @empty
                    <div class="w-news-empty">Nav publicētu diskusiju.</div>
                @endforelse
            </div>
        </div>

        {{-- Newest games --}}
        <div class="w-section">
            <div class="w-sh">
                JAUNĀKĀS SPĒLES
                <a href="{{ route("games.index") }}" class="w-sh-link">VISAS &rsaquo;</a>
            </div>
            <div class="w-news">
                @forelse ($newGames as $game)
                    <div class="w-ni">
                        <span class="w-nd">{{ $game->created_at->format("d.m.Y") }}</span>
                        <a href="{{ route("games.show", $game) }}" class="w-nl">
                            {{ $game->title }}
                            @if($game->developer)
                                <span style="font-weight:normal; color:#666;"> — {{ $game->developer->name }}</span>
                            @endif
                        </a>
                    </div>
                @empty
                    <div class="w-news-empty">Nav pievienotu spēļu.</div>
                @endforelse
            </div>
        </div>

    </div>{{-- /w-left --}}

    {{-- RIGHT --}}
    <div class="w-right">

        {{-- Counter --}}
        <div class="w-section">
            <div class="w-sh">PORTĀLA STATISTIKA</div>
            <div class="w-counter">
                <div class="w-cnt-num">{{ number_format($totalGames + $totalComm) }}</div>
                <div class="w-cnt-lbl">spēles un kopienas</div>
                <a href="{{ route("games.index") }}" class="w-cnt-link">SKATĪT KATALOGU &rsaquo;</a>
            </div>
        </div>

        {{-- Stats table --}}
        <div class="w-section">
            <div class="w-sh">GALVENIE RĀDĪTĀJI</div>
            <table class="w-stats">
                <tr><td class="w-sl">Spēles</td><td class="w-sv">{{ number_format($totalGames) }}</td></tr>
                <tr><td class="w-sl">Kopienas</td><td class="w-sv">{{ number_format($totalComm) }}</td></tr>
                <tr><td class="w-sl">Izstrādātāji</td><td class="w-sv">{{ number_format($totalDev) }}</td></tr>
                <tr><td class="w-sl">Reģistrētie lietotāji</td><td class="w-sv">{{ number_format($totalUsers) }}</td></tr>
                <tr><td class="w-sl">Žanri</td><td class="w-sv">{{ number_format($totalGenres) }}</td></tr>
                <tr><td class="w-sl">Platformas</td><td class="w-sv">{{ number_format($totalPlat) }}</td></tr>
                <tr><td class="w-sl">Publikācijas</td><td class="w-sv">{{ number_format($totalPosts) }}</td></tr>
            </table>
        </div>

        {{-- Auth box --}}
        @guest
        <div class="w-section">
            <div class="w-sh">PIEKĻUVE</div>
            <div class="w-auth">
                <a href="{{ route("register") }}" class="w-auth-btn primary">Reģistrēties</a>
                <a href="{{ route("login") }}" class="w-auth-btn">Pieslēgties</a>
            </div>
        </div>
        @else
        <div class="w-section">
            <div class="w-sh">MANS KONTS</div>
            <div class="w-auth">
                <a href="{{ route("dashboard") }}" class="w-auth-btn primary">Mans profils</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ url("/admin") }}" class="w-auth-btn">Admin panelis</a>
                @endif
            </div>
        </div>
        @endguest

        {{-- Support --}}
        <div class="w-section">
            <div class="w-sh">ATBALSTS</div>
            <div class="w-support">
                <div class="w-sr">
                    <span class="w-si">&#9993;</span>
                    <a href="{{ route("contact.index") }}" class="w-link">Rakstīt mums</a>
                </div>
                <div class="w-sr">
                    <span class="w-si">&#9201;</span>
                    <span class="w-st">P–Pk &nbsp;9:00–17:00</span>
                </div>
                <a href="{{ route("contact.index") }}" class="w-btn">Nosūtīt pieprasījumu</a>
            </div>
        </div>

        {{-- About --}}
        <div class="w-section">
            <div class="w-sh">PAR PORTĀLU</div>
            <div class="w-about">
                <p>GameHub ir spēlētāju kopienas platforma ar spēļu katalogu, žanru klasifikatoru un diskusiju blogu.</p>
                <p><a href="{{ route("contact.index") }}" class="w-link">Sazināties &rsaquo;</a></p>
            </div>
        </div>

    </div>{{-- /w-right --}}
</div>{{-- /w-main --}}

{{-- FOOTER --}}
<div class="w-footer">
    <div class="w-fi">
        <span class="w-fc">GameHub</span>
        <span class="w-fs">|</span>
        <span>&copy; {{ date("Y") }}</span>
        <span class="w-fs">|</span>
        <a href="{{ route("games.index") }}" class="w-fl">Spēles</a>
        <span class="w-fs">|</span>
        <a href="{{ route("communities.index") }}" class="w-fl">Kopienas</a>
        <span class="w-fs">|</span>
        <a href="{{ route("blog.index") }}" class="w-fl">Blogs</a>
        <span class="w-fs">|</span>
        <a href="{{ route("trending.index") }}" class="w-fl">Tendences</a>
        <span class="w-fs">|</span>
        <a href="{{ route("genres.index") }}" class="w-fl">Žanri</a>
        <span class="w-fs">|</span>
        <a href="{{ route("platforms.index") }}" class="w-fl">Platformas</a>
        <span class="w-fs">|</span>
        <a href="{{ route("contact.index") }}" class="w-fl">Kontakts</a>
    </div>
</div>

</body>
</html>