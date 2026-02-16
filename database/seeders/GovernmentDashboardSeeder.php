<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Genre;
use App\Models\Platform;
use Illuminate\Database\Seeder;

class GovernmentDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds for government-style dashboard demo data.
     */
    public function run(): void
    {
        // Sample Latvian company names for the business register
        $latvianCompanies = [
            ['name' => 'SIA "Latvijas Mobilais Telefons"', 'website' => 'https://lmt.lv'],
            ['name' => 'SIA "Lattelecom"', 'website' => 'https://lattelecom.lv'],
            ['name' => 'SIA "Rīgas Satiksme"', 'website' => 'https://rigassatiksme.lv'],
            ['name' => 'AS "Latvenergo"', 'website' => 'https://latvenergo.lv'],
            ['name' => 'SIA "Rimi Latvia"', 'website' => 'https://rimi.lv'],
            ['name' => 'SIA "Maxima Latvia"', 'website' => 'https://maxima.lv'],
            ['name' => 'AS "Air Baltic"', 'website' => 'https://airbaltic.com'],
            ['name' => 'SIA "Bite Latvia"', 'website' => 'https://bite.lv'],
            ['name' => 'VAS "Latvijas Pasts"', 'website' => 'https://pasts.lv'],
            ['name' => 'AS "Latvijas Gāze"', 'website' => 'https://lg.lv'],
            ['name' => 'SIA "Tele2 Latvia"', 'website' => 'https://tele2.lv'],
            ['name' => 'SIA "Circle K Latvia"', 'website' => 'https://circlek.lv'],
            ['name' => 'AS "Swedbank"', 'website' => 'https://swedbank.lv'],
            ['name' => 'AS "SEB Banka"', 'website' => 'https://seb.lv'],
            ['name' => 'SIA "LMT Retail"', 'website' => 'https://lmt.lv'],
        ];

        foreach ($latvianCompanies as $company) {
            Developer::firstOrCreate(
                ['name' => $company['name']],
                ['website' => $company['website']]
            );
        }

        // Industry categories (in Latvian)
        $industrialCategories = [
            'Telekomunikācijas',
            'Enerģētika',
            'Transports un loģistika',
            'Tirdzniecība',
            'Finanšu pakalpojumi',
            'IT un tehnoloģijas',
            'Būvniecība',
            'Ražošana',
            'Izglītība',
            'Veselība',
        ];

        foreach ($industrialCategories as $category) {
            Genre::firstOrCreate(
                ['name' => $category]
            );
        }

        // Platforms (Digital platforms)
        $platforms = [
            ['name' => 'Web Portal', 'slug' => 'web-portal'],
            ['name' => 'Mobile App', 'slug' => 'mobile-app'],
            ['name' => 'Desktop Application', 'slug' => 'desktop'],
            ['name' => 'API Service', 'slug' => 'api'],
            ['name' => 'Cloud Platform', 'slug' => 'cloud'],
        ];

        foreach ($platforms as $platform) {
            Platform::firstOrCreate(
                ['slug' => $platform['slug']],
                ['name' => $platform['name']]
            );
        }

        $this->command->info('✅ Government dashboard demo data seeded successfully!');
        $this->command->info('📊 Created: ' . count($latvianCompanies) . ' companies');
        $this->command->info('🏷️  Created: ' . count($industrialCategories) . ' categories');
        $this->command->info('💻 Created: ' . count($platforms) . ' platforms');
    }
}
