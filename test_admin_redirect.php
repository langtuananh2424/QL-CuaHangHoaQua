<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Factories\DashboardFactory;
use App\Models\User;

// Tìm admin user
$admin = User::where('role', 'admin')->first();

if ($admin) {
    echo "Admin user found: " . $admin->name . " (" . $admin->email . ")\n";

    // Test DashboardFactory
    $dashboard = DashboardFactory::make($admin->role);

    echo "Dashboard type: " . get_class($dashboard) . "\n";
    echo "Expected redirect: admin.products\n";
} else {
    echo "No admin user found!\n";
}
