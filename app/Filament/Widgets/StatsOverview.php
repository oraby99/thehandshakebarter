<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\User;
use App\Models\Item;
use App\Models\Barter;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\ContactTicket;


class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Active Items', Item::where('item_status_id', 1)->count())
                ->description('Items listed for trade')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
            Stat::make('Categories', Category::count())
                ->description('Total categories')
                ->descriptionIcon('heroicon-m-tag')
                ->color('info'),
            Stat::make('SubCategories', SubCategory::count())
                ->description('Total subcategories')
                ->descriptionIcon('heroicon-m-hashtag')
                ->color('info'),
            Stat::make('Active Barters', Barter::whereIn('status', ['pending', 'accepted'])->count())
                ->description('Trades in progress')
                ->descriptionIcon('heroicon-m-arrows-right-left')
                ->color('warning'),
            Stat::make('Completed Barters', Barter::where('status', 'completed')->count())
                ->description('Successful trades')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Payments', Payment::count())
                ->description('Total transactions')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
            Stat::make('Subscriptions', Subscription::where('is_active', true)->count())
                ->description('Active plans')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('primary'),
            Stat::make('Open Tickets', ContactTicket::where('status', 'open')->count())
                ->description('Pending support requests')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('danger'),

        ];
    }
}
