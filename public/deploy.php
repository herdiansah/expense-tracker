<?php

/**
 * Web-based deployment helper for servers without terminal access.
 * 
 * SECURITY: Protected by a one-time token. After use, delete this file
 * or change the token immediately.
 * 
 * Usage: https://your-domain.com/deploy.php?token=YOUR_TOKEN&action=migrate
 * 
 * Available actions:
 *   - migrate     : Run pending database migrations
 *   - cache       : Cache config, routes, and views
 *   - clear       : Clear all caches
 *   - status      : Show migration status and app info
 *   - link        : Create storage symlink
 */

// ============================================================
// CHANGE THIS TOKEN BEFORE UPLOADING TO PRODUCTION!
// ============================================================
$DEPLOY_TOKEN = 'T6ymPq2vKR2wL4ND8'; // Change this!

// ============================================================
// Bootstrap Laravel
// ============================================================
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = \Illuminate\Http\Request::capture()
);

// ============================================================
// Security Check
// ============================================================
$token = $_GET['token'] ?? '';
$action = $_GET['action'] ?? '';

header('Content-Type: text/plain; charset=utf-8');

if ($token !== $DEPLOY_TOKEN) {
    http_response_code(403);
    echo "⛔ Access denied.\n";
    exit;
}

if (!$action) {
    echo "Expense Tracker — Deploy Helper\n";
    echo "================================\n\n";
    echo "Available actions:\n";
    echo "  ?action=migrate   — Run pending migrations\n";
    echo "  ?action=cache     — Cache config/routes/views\n";
    echo "  ?action=clear     — Clear all caches\n";
    echo "  ?action=status    — Show app & migration status\n";
    echo "  ?action=link      — Create storage symlink\n";
    exit;
}

echo "Action: {$action}\n";
echo str_repeat('=', 40) . "\n\n";

try {
    switch ($action) {
        case 'migrate':
            echo \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            echo \Illuminate\Support\Facades\Artisan::output();
            break;

        case 'cache':
            \Illuminate\Support\Facades\Artisan::call('config:cache');
            echo \Illuminate\Support\Facades\Artisan::output();
            \Illuminate\Support\Facades\Artisan::call('route:cache');
            echo \Illuminate\Support\Facades\Artisan::output();
            \Illuminate\Support\Facades\Artisan::call('view:cache');
            echo \Illuminate\Support\Facades\Artisan::output();
            echo "\n✅ All caches built.\n";
            break;

        case 'clear':
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            echo \Illuminate\Support\Facades\Artisan::output();
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            echo \Illuminate\Support\Facades\Artisan::output();
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            echo \Illuminate\Support\Facades\Artisan::output();
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            echo \Illuminate\Support\Facades\Artisan::output();
            echo "\n✅ All caches cleared.\n";
            break;

        case 'status':
            echo "APP_ENV:   " . config('app.env') . "\n";
            echo "APP_DEBUG: " . (config('app.debug') ? 'true' : 'false') . "\n";
            echo "APP_URL:   " . config('app.url') . "\n";
            echo "DB:        " . config('database.connections.mysql.database') . "\n";
            echo "MAILER:    " . config('mail.default') . "\n";
            echo "PHP:       " . phpversion() . "\n\n";
            \Illuminate\Support\Facades\Artisan::call('migrate:status');
            echo \Illuminate\Support\Facades\Artisan::output();
            break;

        case 'link':
            \Illuminate\Support\Facades\Artisan::call('storage:link');
            echo \Illuminate\Support\Facades\Artisan::output();
            break;

        default:
            echo "❌ Unknown action: {$action}\n";
    }
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
