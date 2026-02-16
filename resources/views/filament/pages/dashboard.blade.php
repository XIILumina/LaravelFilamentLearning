<x-filament-panels::page>
    <div class="gov-portal-dashboard">
        <!-- Header Section -->
        <div class="gov-header">
            <div class="gov-title-section">
                <h1 class="gov-main-title">Laipni lūdzam Uzņēmumu Reģistra Portālā</h1>
                <p class="gov-subtitle">Datu portāls nodrošina brīvu piekļuvi reģistrēto uzņēmumu, produktu un publisko datu bāzei</p>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="gov-stats-section">
            <h2 class="section-title">Statistika</h2>
            @livewire(\App\Filament\Widgets\RegisteredEntitiesWidget::class)
            @livewire(\App\Filament\Widgets\IndustryStatsWidget::class)
        </div>

        <!-- Categories Section -->
        <div class="gov-categories-section">
            <h2 class="section-title">Datu Kataloga Kategorijas</h2>
            <div class="category-grid">
                <a href="/admin/developers" class="category-card">
                    <div class="category-icon">🏢</div>
                    <div class="category-name">Uzņēmumi</div>
                    <div class="category-desc">Reģistrētie uzņēmumi un organizācijas</div>
                </a>
                
                <a href="/admin/games" class="category-card">
                    <div class="category-icon">📦</div>
                    <div class="category-name">Produkti un Pakalpojumi</div>
                    <div class="category-desc">Publiskotie produkti un pakalpojumu katalogs</div>
                </a>
                
                <a href="/admin/genres" class="category-card">
                    <div class="category-icon">🏷️</div>
                    <div class="category-name">Industriju Kategorijas</div>
                    <div class="category-desc">Biznesa un industriju klasifikācija</div>
                </a>
                
                <a href="/admin/platforms" class="category-card">
                    <div class="category-icon">💻</div>
                    <div class="category-name">Platformas</div>
                    <div class="category-desc">Pieejamās digitālās platformas</div>
                </a>
                
                <a href="/admin/posts" class="category-card">
                    <div class="category-icon">📰</div>
                    <div class="category-name">Publikācijas</div>
                    <div class="category-desc">Jaunumi un industrijas ziņas</div>
                </a>
                
                <a href="/admin/communities" class="category-card">
                    <div class="category-icon">👥</div>
                    <div class="category-name">Kopienas</div>
                    <div class="category-desc">Profesionālās kopienas un tīkli</div>
                </a>
            </div>
        </div>

        <!-- Recent Data -->
        <div class="gov-recent-section">
            <h2 class="section-title">Datu Analīze</h2>
            <div style="margin-bottom: 2rem;">
                @livewire(\App\Filament\Widgets\DataCatalogChart::class)
            </div>
            
            <h2 class="section-title">Jaunākie Dati</h2>
            @livewire(\App\Filament\Widgets\RecentCompaniesWidget::class)
            
            <div style="margin-top: 2rem;">
                @livewire(\App\Filament\Widgets\TopCategoriesWidget::class)
            </div>
        </div>

        <!-- Info Section -->
        <div class="gov-info-section">
            <div class="info-card">
                <h3>Par portālu</h3>
                <p>Šis portāls sniedz piekļuvi uzņēmumu reģistra datiem un statistikai. Dati tiek regulāri atjaunināti un ir pieejami publiskai izmantošanai.</p>
            </div>
            <div class="info-card">
                <h3>Datu izmantošana</h3>
                <p>Visi dati ir pieejami saskaņā ar atvērto datu principiem. Aicinām izmantot šos datus analītikā, pētījumos un digitālo risinājumu izstrādē.</p>
            </div>
        </div>
    </div>

    <style>
        .gov-portal-dashboard {
            max-width: 1400px;
            margin: 0 auto;
        }

        .gov-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            padding: 3rem 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .gov-main-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .gov-subtitle {
            font-size: 1.125rem;
            opacity: 0.95;
            line-height: 1.6;
            max-width: 800px;
        }

        .gov-stats-section,
        .gov-categories-section,
        .gov-recent-section {
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 3px solid #3b82f6;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-top: 1.5rem;
        }

        .category-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .category-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
            transform: translateY(-2px);
        }

        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        .category-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .category-desc {
            font-size: 0.875rem;
            color: #64748b;
            line-height: 1.5;
        }

        .gov-info-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
        }

        .info-card {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }

        .info-card h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.75rem;
        }

        .info-card p {
            font-size: 0.9375rem;
            color: #475569;
            line-height: 1.6;
        }

        /* Override Filament widget styles for government look */
        .fi-wi-stats-overview {
            background: transparent;
        }

        .fi-wi-stats-overview-stat {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
        }

        .fi-wi-stats-overview-stat:hover {
            border-color: #cbd5e1;
        }

        /* Dark mode adjustments */
        .dark .section-title {
            color: #f1f5f9;
            border-bottom-color: #3b82f6;
        }

        .dark .category-card {
            background: #1e293b;
            border-color: #334155;
        }

        .dark .category-name {
            color: #f1f5f9;
        }

        .dark .category-desc {
            color: #94a3b8;
        }

        .dark .info-card {
            background: #1e293b;
        }

        .dark .info-card h3 {
            color: #f1f5f9;
        }

        .dark .info-card p {
            color: #cbd5e1;
        }
    </style>
</x-filament-panels::page>
