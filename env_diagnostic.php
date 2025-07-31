<?php
// env_diagnostic.php - Diagnostic tool untuk masalah .env Laravel

echo "=== Laravel .env Diagnostic Tool ===\n\n";

// 1. Cek current working directory
echo "1. Current Working Directory: " . getcwd() . "\n";
echo "   Script location: " . __DIR__ . "\n\n";

// 2. Cek file .env
echo "2. Checking .env file:\n";
$envPath = __DIR__ . '/.env';
$envExists = file_exists($envPath);

echo "   .env path: {$envPath}\n";
echo "   .env exists: " . ($envExists ? 'YES' : 'NO') . "\n";

if ($envExists) {
    $envSize = filesize($envPath);
    $envPermission = substr(sprintf('%o', fileperms($envPath)), -4);
    echo "   .env size: {$envSize} bytes\n";
    echo "   .env permission: {$envPermission}\n";
    
    // Cek beberapa baris pertama
    $envContent = file_get_contents($envPath);
    $envLines = explode("\n", $envContent);
    echo "   .env first 5 lines:\n";
    foreach (array_slice($envLines, 0, 5) as $i => $line) {
        $lineNum = $i + 1;
        echo "     {$lineNum}: " . trim($line) . "\n";
    }
    
    // Cek apakah ada GOOGLE_DRIVE vars
    echo "\n   Google Drive variables in .env:\n";
    foreach ($envLines as $line) {
        if (strpos($line, 'GOOGLE_DRIVE') !== false) {
            $parts = explode('=', $line, 2);
            if (count($parts) == 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                if (strpos($key, 'SECRET') !== false || strpos($key, 'TOKEN') !== false) {
                    echo "     {$key}=" . substr($value, 0, 20) . "...\n";
                } else {
                    echo "     {$key}={$value}\n";
                }
            }
        }
    }
} else {
    echo "   ❌ .env file not found!\n";
}

echo "\n" . str_repeat("-", 50) . "\n";

// 3. Test PHP env() function TANPA Laravel
echo "3. Testing PHP env() function (without Laravel):\n";
$testVars = ['APP_NAME', 'APP_ENV', 'GOOGLE_DRIVE_CLIENT_ID', 'GOOGLE_DRIVE_REFRESH_TOKEN'];

foreach ($testVars as $var) {
    $value = getenv($var) ?: ($_ENV[$var] ?? 'NOT_FOUND');
    if (strpos($var, 'SECRET') !== false || strpos($var, 'TOKEN') !== false) {
        echo "   {$var}: " . ($value !== 'NOT_FOUND' ? substr($value, 0, 20) . '...' : 'NOT_FOUND') . "\n";
    } else {
        echo "   {$var}: {$value}\n";
    }
}

echo "\n" . str_repeat("-", 50) . "\n";

// 4. Manual load .env menggunakan vlucas/phpdotenv
echo "4. Manual .env loading test:\n";
try {
    if ($envExists) {
        // Load .env manual
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $envVars = [];
        
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && !str_starts_with(trim($line), '#')) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                $envVars[$key] = $value;
            }
        }
        
        echo "   Manual parsing results:\n";
        foreach ($testVars as $var) {
            $value = $envVars[$var] ?? 'NOT_FOUND';
            if (strpos($var, 'SECRET') !== false || strpos($var, 'TOKEN') !== false) {
                echo "   {$var}: " . ($value !== 'NOT_FOUND' ? substr($value, 0, 20) . '...' : 'NOT_FOUND') . "\n";
            } else {
                echo "   {$var}: {$value}\n";
            }
        }
    }
} catch (Exception $e) {
    echo "   ❌ Manual parsing failed: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n";

// 5. Test Laravel loading
echo "5. Testing Laravel environment loading:\n";
try {
    // Load Laravel tanpa bootstrap penuh
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
        echo "   ✓ Composer autoload loaded\n";
        
        // Load .env menggunakan Laravel's Dotenv
        if (class_exists('Dotenv\\Dotenv')) {
            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->load();
            echo "   ✓ Dotenv loaded\n";
            
            // Test env() setelah Dotenv load
            foreach ($testVars as $var) {
                $value = $_ENV[$var] ?? getenv($var) ?: 'NOT_FOUND';
                if (strpos($var, 'SECRET') !== false || strpos($var, 'TOKEN') !== false) {
                    echo "   {$var}: " . ($value !== 'NOT_FOUND' ? substr($value, 0, 20) . '...' : 'NOT_FOUND') . "\n";
                } else {
                    echo "   {$var}: {$value}\n";
                }
            }
        } else {
            echo "   ❌ Dotenv class not found\n";
        }
    } else {
        echo "   ❌ vendor/autoload.php not found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Laravel Dotenv loading failed: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n";

// 6. Test full Laravel bootstrap
echo "6. Testing full Laravel bootstrap:\n";
try {
    if (file_exists(__DIR__ . '/bootstrap/app.php')) {
        $app = require_once __DIR__ . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        echo "   ✓ Laravel application bootstrapped\n";
        
        // Test env() function
        foreach ($testVars as $var) {
            $value = env($var, 'NOT_FOUND');
            if (strpos($var, 'SECRET') !== false || strpos($var, 'TOKEN') !== false) {
                echo "   env('{$var}'): " . ($value !== 'NOT_FOUND' ? substr($value, 0, 20) . '...' : 'NOT_FOUND') . "\n";
            } else {
                echo "   env('{$var}'): {$value}\n";
            }
        }
        
        // Test config() function
        echo "\n   Testing config() function:\n";
        $configTests = [
            'app.name',
            'app.env', 
            'services.google.client_id',
            'services.google.refresh_token'
        ];
        
        foreach ($configTests as $configKey) {
            $value = config($configKey, 'NOT_FOUND');
            if (strpos($configKey, 'secret') !== false || strpos($configKey, 'refresh_token') !== false) {
                echo "   config('{$configKey}'): " . ($value !== 'NOT_FOUND' ? substr($value, 0, 20) . '...' : 'NOT_FOUND') . "\n";
            } else {
                echo "   config('{$configKey}'): {$value}\n";
            }
        }
        
    } else {
        echo "   ❌ bootstrap/app.php not found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Laravel bootstrap failed: " . $e->getMessage() . "\n";
    echo "   Error details: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n" . str_repeat("=", 60) . "\n";

// 7. Diagnosis dan Rekomendasi
echo "DIAGNOSIS & RECOMMENDATIONS:\n\n";

if (!$envExists) {
    echo "❌ CRITICAL: .env file not found!\n";
    echo "   Solutions:\n";
    echo "   - Copy .env.example to .env: cp .env.example .env\n";
    echo "   - Make sure you're in the correct project directory\n\n";
} else {
    // Analisis hasil
    $manualWorks = isset($envVars) && isset($envVars['APP_NAME']);
    $laravelWorks = false;
    
    // Cek apakah Laravel env() bekerja dengan mencoba load ulang
    try {
        if (function_exists('env')) {
            $laravelWorks = env('APP_NAME') !== null;
        }
    } catch (Exception $e) {
        // Laravel env() tidak bekerja
    }
    
    if ($manualWorks && !$laravelWorks) {
        echo "⚠️  .env file exists and readable, but Laravel can't load it!\n";
        echo "   Possible issues:\n";
        echo "   - Configuration cache is corrupted\n";
        echo "   - Laravel bootstrap issue\n";
        echo "   - Permission problems\n\n";
        
        echo "   Try these solutions:\n";
        echo "   1. php artisan config:clear\n";
        echo "   2. php artisan cache:clear\n";
        echo "   3. rm -f bootstrap/cache/config.php\n";
        echo "   4. rm -f bootstrap/cache/services.php\n";
        echo "   5. composer dump-autoload\n";
        echo "   6. chmod 644 .env\n\n";
        
    } elseif (!$manualWorks) {
        echo "❌ .env file exists but has parsing issues!\n";
        echo "   Check for:\n";
        echo "   - Syntax errors in .env\n";
        echo "   - Special characters without quotes\n";
        echo "   - Missing = signs\n";
        echo "   - File encoding issues\n\n";
        
    } else {
        echo "✓ .env file loading works!\n";
        echo "   The issue might be in your GoogleDriveService constructor\n";
        echo "   or service provider configuration.\n\n";
    }
}

echo "Next steps:\n";
echo "1. Run the recommended solutions above\n";
echo "2. Create a simple test: echo env('APP_NAME');\n";
echo "3. If still failing, check file permissions and ownership\n";
echo "4. Consider recreating .env from .env.example\n";