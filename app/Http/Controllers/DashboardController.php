<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all users with pagination
        $users = User::orderBy('created_at', 'desc')
                    ->paginate(10);

        // Get the last 6 months
        $months = collect(range(5, 0))->map(function($i) {
            return Carbon::now()->subMonths($i)->format('Y-m');
        });

        // Get monthly user counts
        $monthlyUsers = $months->mapWithKeys(function($month) {
            return [$month => User::whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count()];
        });

        // Get monthly premium user counts
        $monthlyPremiumUsers = $months->mapWithKeys(function($month) {
            return [$month => User::where('is_premium', true)
                ->whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count()];
        });

        $stats = [
            'total_users' => User::count(),
            'free_users' => User::where('is_premium', false)->count(),
            'premium_users' => User::where('is_premium', true)->count(),
            'total_income' => User::where('is_premium', true)->count() * 9.99,
            'recent_upgrades' => User::where('is_premium', true)
                                   ->orderBy('updated_at', 'desc')
                                   ->take(5)
                                   ->get(),
            'conversion_rate' => User::count() > 0 
                ? round((User::where('is_premium', true)->count() / User::count()) * 100, 2) 
                : 0,
            'monthly_labels' => $months->map(function($month) {
                return Carbon::createFromFormat('Y-m', $month)->format('M Y');
            })->values(),
            'monthly_users' => $monthlyUsers->values(),
            'monthly_premium_users' => $monthlyPremiumUsers->values()
        ];

        return view('dashboard.index', compact('stats', 'users'));
    }
} 