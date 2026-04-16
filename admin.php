<?php

/**
 * Admin Account Creator Script
 * Run: php admin.php
 * Creates admin account with credentials
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

echo "\n" . str_repeat("=", 60) . "\n";
echo "       ADMIN ACCOUNT CREATOR\n";
echo str_repeat("=", 60) . "\n\n";

try {
    // Check if admin already exists
    $existingAdmin = Admin::where('email', 'admin@trademark.com')->first();

    if ($existingAdmin) {
        echo "✅ Admin already exists!\n\n";
        echo "Email: admin@trademark.com\n";
        echo "Password: admin@123\n\n";
    } else {
        // Create new admin account
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@trademark.com',
            'password' => Hash::make('admin@123'),
        ]);

        echo "✅ Admin account created successfully!\n\n";
        echo "📧 Email: admin@trademark.com\n";
        echo "🔑 Password: admin@123\n\n";
        echo "⚠️  IMPORTANT: Change password after first login!\n\n";
    }

    // List all admins
    echo str_repeat("-", 60) . "\n";
    echo "ALL ADMIN ACCOUNTS:\n";
    echo str_repeat("-", 60) . "\n";

    $admins = Admin::all();
    if ($admins->count() > 0) {
        foreach ($admins as $admin) {
            echo "ID: {$admin->id} | Name: {$admin->name} | Email: {$admin->email}\n";
        }
    } else {
        echo "No admin accounts found\n";
    }

    echo "\n" . str_repeat("=", 60) . "\n";
    echo "🌐 LOGIN URL: http://localhost:8000/login\n";
    echo str_repeat("=", 60) . "\n\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
    exit(1);
}

exit(0);
