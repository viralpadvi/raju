<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SettingResource;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    public function index()
    {
        return SettingResource::collection(Setting::all());
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'store_name' => ['nullable', 'string', 'max:255'],
            'store_email' => ['nullable', 'email', 'max:255'],
            'store_phone' => ['nullable', 'string', 'max:50'],
            'store_address' => ['nullable', 'string'],
            'currency' => ['nullable', 'string', 'max:10'],
            'favicon' => ['nullable', 'image', 'mimes:ico,png,jpg,jpeg', 'max:2048'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'smtp_settings' => ['nullable', 'array'],
            'payment_settings' => ['nullable', 'array'],
            'sms_settings' => ['nullable', 'array'],
        ]);

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = 'favicon.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path(), $faviconName);
            Setting::set('favicon', $faviconName);
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo.' . $logo->getClientOriginalExtension();
            $logoPath = $logo->storeAs('images', $logoName, 'public');
            Setting::set('logo', $logoPath);
        }

        foreach (['store_name', 'store_email', 'store_phone', 'store_address', 'currency'] as $key) {
            if (array_key_exists($key, $validated)) {
                Setting::set($key, $validated[$key]);
            }
        }

        if (isset($validated['currency'])) {
            $this->updateCurrencyConfig($validated['currency']);
        }

        if (isset($validated['smtp_settings'])) {
            Setting::set('smtp_settings', $validated['smtp_settings'], 'json');
        }

        if (isset($validated['payment_settings'])) {
            Setting::set('payment_settings', $validated['payment_settings'], 'json');
        }

        if (isset($validated['sms_settings'])) {
            Setting::set('sms_settings', $validated['sms_settings'], 'json');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Settings updated successfully.',
        ]);
    }

    public function createBackup(): JsonResponse
    {
        try {
            $database = config('database.connections.mysql.database');
            $backupDir = storage_path('app/backups');

            if (!File::exists($backupDir)) {
                File::makeDirectory($backupDir, 0755, true);
            }

            $backupFile = $backupDir . '/backup_' . now()->format('Y_m_d_His') . '.sql';

            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                escapeshellarg(config('database.connections.mysql.username')),
                escapeshellarg(config('database.connections.mysql.password')),
                escapeshellarg(config('database.connections.mysql.host')),
                escapeshellarg($database),
                escapeshellarg($backupFile)
            );

            exec($command, $output, $result);

            if ($result !== 0 || !File::exists($backupFile)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create backup.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Backup created: ' . basename($backupFile),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function clearCache(): JsonResponse
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return response()->json([
                'status' => 'success',
                'message' => 'Cache cleared successfully.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateSystem(): JsonResponse
    {
        try {
            Artisan::call('migrate', ['--force' => true]);

            return response()->json([
                'status' => 'success',
                'message' => 'System updated successfully.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function reset(): JsonResponse
    {
        try {
            Setting::whereNotIn('key', ['favicon', 'logo'])->delete();
            Setting::set('store_name', 'A R Electronics');
            Setting::set('store_email', 'info@arelectronics.com');
            Setting::set('currency', 'INR');

            return response()->json([
                'status' => 'success',
                'message' => 'Settings reset to defaults.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function updateCurrencyConfig(string $currency): void
    {
        $configPath = config_path('app.php');
        $config = file_get_contents($configPath);

        $pattern = "/'currency'\\s*=>\\s*env\\('APP_CURRENCY',\\s*'[^']+'\\),/";
        $replacement = "'currency' => env('APP_CURRENCY', '{$currency}'),";

        if (preg_match($pattern, $config)) {
            $config = preg_replace($pattern, $replacement, $config);
            file_put_contents($configPath, $config);
        }
    }
}

