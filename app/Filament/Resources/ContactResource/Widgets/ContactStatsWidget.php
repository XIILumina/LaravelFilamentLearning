<?php

namespace App\Filament\Resources\ContactResource\Widgets;

use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ContactStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Messages', Contact::where('status', 'pending')->count())
                ->description('Messages awaiting response')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('In Progress', Contact::where('status', 'in_progress')->count())
                ->description('Currently being handled')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),

            Stat::make('Resolved Today', Contact::where('status', 'resolved')
                ->whereDate('responded_at', today())
                ->count())
                ->description('Messages resolved today')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Messages', Contact::count())
                ->description('All time contact messages')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('primary'),

            Stat::make('Avg Response Time', $this->getAverageResponseTime())
                ->description('Average time to respond')
                ->descriptionIcon('heroicon-m-clock')
                ->color('gray'),

            Stat::make('This Week', Contact::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count())
                ->description('Messages this week')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary')
                ->chart([1, 3, 2, 5, 8, 12, 10]),
        ];
    }

    private function getAverageResponseTime(): string
    {
        $resolvedMessages = Contact::whereNotNull('responded_at')
            ->whereNotNull('created_at')
            ->get();

        if ($resolvedMessages->isEmpty()) {
            return 'N/A';
        }

        $totalHours = $resolvedMessages->sum(function ($message) {
            return $message->created_at->diffInHours($message->responded_at);
        });

        $averageHours = $totalHours / $resolvedMessages->count();

        if ($averageHours < 1) {
            return round($averageHours * 60) . ' min';
        } elseif ($averageHours < 24) {
            return round($averageHours, 1) . ' hrs';
        } else {
            return round($averageHours / 24, 1) . ' days';
        }
    }
}