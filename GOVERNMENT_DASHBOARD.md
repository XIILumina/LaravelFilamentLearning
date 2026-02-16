# Uzņēmumu Reģistra Portāls - Government Style Dashboard

## Kas tika izveidots / What was created

Tev esmu izveidojis valdības stila (data.gov.lv) paneli Filament sistēmā ar šādām funkcijām:

### 📊 Widgets (Logrīki)

1. **RegisteredEntitiesWidget** - Statistika par reģistrētajiem uzņēmumiem, lietotājiem, produktiem un kopienām
2. **IndustryStatsWidget** - Industriju kategorijas, platformas, publikācijas un kontaktu statistika  
3. **DataCatalogChart** - Grafiks ar datu kataloga izaugsmi (līniju diagramma)
4. **RecentCompaniesWidget** - Tabula ar jaunākajiem reģistrētajiem uzņēmumiem
5. **TopCategoriesWidget** - TOP 10 populārākās kategorijas

### 🎨 Dizains / Design

- **Valdības stils**: Zils krāsu shēma (blue), tīrs dizains kā data.gov.lv
- **Responsīvs**: Pielāgojas dažādiem ekrānu izmēriem
- **Kategoriju kartes**: 6 kategoriju kartes ar ikonām
- **Custom CSS**: Gov-portal.css ar valdības stila stiliem

### 📁 Izveidotie faili / Created files

```
app/Filament/
├── Pages/
│   └── Dashboard.php (custom dashboard page)
├── Widgets/
│   ├── RegisteredEntitiesWidget.php
│   ├── IndustryStatsWidget.php
│   ├── DataCatalogChart.php
│   ├── RecentCompaniesWidget.php
│   └── TopCategoriesWidget.php

resources/
├── views/filament/pages/
│   └── dashboard.blade.php (government style view)
└── css/
    └── gov-portal.css (custom styles)
```

## 🚀 Kā izmantot / How to use

1. **Apmeklē admin paneli**: Ej uz `/admin`
2. **Ienāc sistēmā**: Lieto savu admin kontu
3. **Sākumlapa**: Redzēsi jauno valdības stila dashboard ar:
   - Statistikas kartes (stats cards)
   - Kategoriju sadaļu
   - Grafiku ar izaugsmi
   - Jaunāko uzņēmumu tabulu
   - TOP kategoriju tabulu

## 🎨 Krāsu shēma / Color scheme

- **Primary Blue**: #3b82f6 (līdzīgi data.gov.lv)
- **Dark Blue**: #1e40af
- **Gray**: #64748b
- **Light Gray**: #f8fafc

## 📝 Pielāgošana / Customization

### Mainīt nosaukumus valodā:
Rediģē widgetus un nomainīt tekstu no latviešu uz citu valodu, ja nepieciešams.

### Pievienot vairāk kategoriju:
Rediģē `dashboard.blade.php` un pievieno vairāk `.category-card` elementus.

### Mainīt krāsas:
Rediģē `gov-portal.css` failu un nomainīt `--gov-primary` mainīgos.

### Pievienot vairāk widgetus:
1. Izveido jaunu widget klasi `app/Filament/Widgets/`
2. Reģistrē to `AdminPanelProvider.php`
3. Pievieno to `Dashboard.php` widgetos

## 🌐 Līdzīgas vietnes / Similar sites

Šis dizains ir iedvesmots no:
- **data.gov.lv** - Latvijas Atvērto Datu portāls
- **firmas.lv** - Uzņēmumu reģistra stils

## 📊 Datu avoti / Data sources

Widgeti izmanto šādus modeļus:
- `Developer` (uzņēmumi)
- `User` (lietotāji)
- `Game` (produkti)
- `Genre` (kategorijas)
- `Platform` (platformas)
- `Post` (publikācijas)
- `Community` (kopienas)
- `Contact` (kontakti)

## ✨ Features

✅ Government-style design (valdības stils)
✅ Latvian language (latviešu valoda)
✅ Responsive layout (responsīvs)
✅ Statistics cards (statistikas kartes)
✅ Data charts (datu grafiki)
✅ Business register table (uzņēmumu reģistra tabula)
✅ Category cards (kategoriju kartes)
✅ Dark mode support (tumšais režīms)

## 🔧 Problēmu risināšana / Troubleshooting

**Ja neredzi widgetus:**
```bash
php artisan filament:optimize-clear
php artisan optimize:clear
```

**Ja CSS nestylējas:**
```bash
npm run build
```

**Ja trūkst datu:**
- Izpildi seeders lai izveidotu testa datus
- Vai pievieno datus caur admin paneli

## 💡 Padoms no tava lazy developer friend

Now you can show this to your boss and say: "Es izveidoju data.gov.lv stila paneli ar uzņēmumu reģistra statistiku!" 😎

Viss ir gatavs. Just visit `/admin` and you'll see the government-style dashboard!
