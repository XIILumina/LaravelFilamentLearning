# 🚀 Quick Setup Instructions

## Lai palaistu jauno Government Dashboard:

### 1️⃣ Palaist seeder (ja vajag testa datus)
```bash
php artisan db:seed --class=GovernmentDashboardSeeder
```

### 2️⃣ Notīrīt cache
```bash
php artisan filament:optimize-clear
php artisan optimize:clear
```

### 3️⃣ Apmeklēt admin paneli
```
http://localhost/admin
```
vai 
```
http://your-domain.test/admin
```

### 4️⃣ Login
Izmanto savu admin account credentials ko jau ir izveidots.

---

## 🎉 Tas viss! / That's it!

Tagad tev ir government-style dashboard ar:
- ✅ Statistikas kartes (8 gabali)
- ✅ Grafiks ar izaugsmi
- ✅ Uzņēmumu reģistra tabula
- ✅ TOP kategoriju tabula
- ✅ Latvian language
- ✅ data.gov.lv style

---

## 📸 Ko parādīt boss'am:

1. Stats kartes augšā - skaisti zili ar cipariem
2. Kategoriju grid - 6 kartes ar ikonām
3. Grafiks - line chart ar trendu
4. Tabulas - uzņēmumi un kategorijas

Saki viņam: "Es izveidoju data.gov.lv stila dashboard ar firmas.lv uzņēmumu reģistra funkcionalitāti! 😎"

---

## 🔧 Ja kaut kas nedarbojas:

1. Check ka visi widgeti ir registered in `AdminPanelProvider.php` ✅ (already done)
2. Check ka database ir migrēta: `php artisan migrate`
3. Check ka ir dati: `php artisan db:seed --class=GovernmentDashboardSeeder`
4. Clear cache: `php artisan optimize:clear`

---

## 📝 Custom texts

Visi texti ir latviešu valodā. Ja gribi mainīt:
- Widgeti: `app/Filament/Widgets/`
- Dashboard view: `resources/views/filament/pages/dashboard.blade.php`

---

Enjoy your lazy-free government dashboard! 🎊
