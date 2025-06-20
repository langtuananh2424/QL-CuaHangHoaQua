<?php
namespace App\Factories;

class CustomerDashboard implements DashboardInterface
{
    public function redirect()
    {
        return redirect()->route('home');
    }
}
