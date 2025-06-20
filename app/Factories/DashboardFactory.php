<?php
namespace App\Factories;

class DashboardFactory
{
    public static function make($role): DashboardInterface
    {
        return match ($role) {
            'admin' => new AdminDashboard(),
            default => new CustomerDashboard(),
        };
    }
}
