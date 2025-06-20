<?php
namespace App\Factories;

class AdminDashboard implements DashboardInterface
{
    public function redirect()
    {
        return redirect()->route('admin.products');
    }
}
