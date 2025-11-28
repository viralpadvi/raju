<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        
        // Decode JSON settings for easier access in the view
        $smtpSettings = isset($settings['smtp_settings']) ? json_decode($settings['smtp_settings'], true) : [];
        $paymentSettings = isset($settings['payment_settings']) ? json_decode($settings['payment_settings'], true) : [];
        $smsSettings = isset($settings['sms_settings']) ? json_decode($settings['sms_settings'], true) : [];
        
        return view('admin.settings.index', compact('settings', 'smtpSettings', 'paymentSettings', 'smsSettings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // General Settings
            'store_name' => 'nullable|string|max:255',
            'store_email' => 'nullable|email|max:255',
            'store_phone' => 'nullable|string|max:50',
            'store_gst_number' => 'nullable|string|max:50',
            'store_address' => 'nullable|string',
            'currency' => 'nullable|string|max:10',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg|max:2048',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            
            // SMTP Settings
            'smtp_enabled' => 'nullable|boolean',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string',
            'smtp_encryption' => 'nullable|in:tls,ssl,',
            'smtp_from_email' => 'nullable|email|max:255',
            'smtp_from_name' => 'nullable|string|max:255',
            
            // Payment Gateway Settings
            'payment_gateway' => 'nullable|string|max:50',
            'stripe_enabled' => 'nullable|boolean',
            'stripe_key' => 'nullable|string|max:255',
            'stripe_secret' => 'nullable|string|max:255',
            'stripe_test_mode' => 'nullable|boolean',
            'razorpay_enabled' => 'nullable|boolean',
            'razorpay_key' => 'nullable|string|max:255',
            'razorpay_secret' => 'nullable|string|max:255',
            
            // SMS Settings
            'sms_provider' => 'nullable|string|max:50',
            'sms_enabled' => 'nullable',
            'twilio_sid' => 'nullable|string|max:255',
            'twilio_token' => 'nullable|string|max:255',
            'twilio_from' => 'nullable|string|max:50',
            'sms_country_code' => 'nullable|string|max:10',
            'msg91_enabled' => 'nullable',
            'msg91_key' => 'nullable|string|max:255',
            'msg91_sender' => 'nullable|string|max:50',
        ]);

        try {
            // Handle file uploads
            if ($request->hasFile('favicon')) {
                $favicon = $request->file('favicon');
                $faviconName = 'favicon.' . $favicon->getClientOriginalExtension();
                $favicon->move(public_path(), $faviconName);
                Setting::set('favicon', $faviconName, 'string');
            }

            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoName = 'logo.' . $logo->getClientOriginalExtension();
                $logoPath = $logo->storeAs('images', $logoName, 'public');
                Setting::set('logo', $logoPath, 'string');
            }

            // Save general settings
            if (isset($validated['store_name'])) {
                Setting::set('store_name', $validated['store_name']);
            }
            if (isset($validated['store_email'])) {
                Setting::set('store_email', $validated['store_email']);
            }
            if (isset($validated['store_phone'])) {
                Setting::set('store_phone', $validated['store_phone']);
            }
            if (isset($validated['store_gst_number'])) {
                Setting::set('store_gst_number', $validated['store_gst_number']);
            }
            if (isset($validated['store_address'])) {
                Setting::set('store_address', $validated['store_address']);
            }
            if (isset($validated['currency'])) {
                Setting::set('currency', $validated['currency']);
                // Update config file
                $this->updateConfigFile('app.currency', $validated['currency']);
            }

            // Save SMTP settings
            $existingSmtp = json_decode(Setting::get('smtp_settings', '{}'), true);
            $smtpSettings = [
                'smtp_enabled' => $request->has('smtp_enabled') ? '1' : '0',
                'smtp_host' => $validated['smtp_host'] ?? ($existingSmtp['smtp_host'] ?? ''),
                'smtp_port' => $validated['smtp_port'] ?? ($existingSmtp['smtp_port'] ?? '587'),
                'smtp_username' => $validated['smtp_username'] ?? ($existingSmtp['smtp_username'] ?? ''),
                'smtp_password' => !empty($validated['smtp_password']) ? $validated['smtp_password'] : ($existingSmtp['smtp_password'] ?? ''),
                'smtp_encryption' => $validated['smtp_encryption'] ?? ($existingSmtp['smtp_encryption'] ?? 'tls'),
                'smtp_from_email' => $validated['smtp_from_email'] ?? ($existingSmtp['smtp_from_email'] ?? ''),
                'smtp_from_name' => $validated['smtp_from_name'] ?? ($existingSmtp['smtp_from_name'] ?? ''),
            ];
            Setting::set('smtp_settings', $smtpSettings, 'json');

            // Save payment gateway settings
            $existingPayment = json_decode(Setting::get('payment_settings', '{}'), true);
            $paymentSettings = [
                'payment_gateway' => $validated['payment_gateway'] ?? ($existingPayment['payment_gateway'] ?? 'stripe'),
                'stripe_enabled' => $request->has('stripe_enabled') ? '1' : '0',
                'stripe_key' => $validated['stripe_key'] ?? ($existingPayment['stripe_key'] ?? ''),
                'stripe_secret' => !empty($validated['stripe_secret']) ? $validated['stripe_secret'] : ($existingPayment['stripe_secret'] ?? ''),
                'stripe_test_mode' => $request->has('stripe_test_mode') ? '1' : '0',
                'razorpay_enabled' => $request->has('razorpay_enabled') ? '1' : '0',
                'razorpay_key' => $validated['razorpay_key'] ?? ($existingPayment['razorpay_key'] ?? ''),
                'razorpay_secret' => !empty($validated['razorpay_secret']) ? $validated['razorpay_secret'] : ($existingPayment['razorpay_secret'] ?? ''),
            ];
            Setting::set('payment_settings', $paymentSettings, 'json');

            // Save SMS settings
            $existingSms = json_decode(Setting::get('sms_settings', '{}'), true);
            $smsSettings = [
                'sms_provider' => $validated['sms_provider'] ?? ($existingSms['sms_provider'] ?? 'twilio'),
                'sms_enabled' => $request->has('sms_enabled') ? '1' : '0',
                'twilio_sid' => $validated['twilio_sid'] ?? ($existingSms['twilio_sid'] ?? ''),
                'twilio_token' => !empty($validated['twilio_token']) ? $validated['twilio_token'] : ($existingSms['twilio_token'] ?? ''),
                'twilio_from' => $validated['twilio_from'] ?? ($existingSms['twilio_from'] ?? ''),
                'sms_country_code' => $validated['sms_country_code'] ?? ($existingSms['sms_country_code'] ?? '+91'),
                'msg91_enabled' => $request->has('msg91_enabled') ? '1' : '0',
                'msg91_key' => $validated['msg91_key'] ?? ($existingSms['msg91_key'] ?? ''),
                'msg91_sender' => $validated['msg91_sender'] ?? ($existingSms['msg91_sender'] ?? ''),
            ];
            Setting::set('sms_settings', $smsSettings, 'json');

            return redirect()->route('admin.settings')
                ->with('success', 'Settings updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Settings Update Error: ' . $e->getMessage());
            return redirect()->route('admin.settings')
                ->with('error', 'Error updating settings: ' . $e->getMessage());
        }
    }

    /**
     * Update config file
     */
    private function updateConfigFile($key, $value)
    {
        $configPath = config_path('app.php');
        $config = file_get_contents($configPath);
        
        // Simple replacement - in production, use a proper config updater
        $pattern = "/'currency'\s*=>\s*env\('APP_CURRENCY',\s*'[^']+'\),/";
        $replacement = "'currency' => env('APP_CURRENCY', '{$value}'),";
        
        if (preg_match($pattern, $config)) {
            $config = preg_replace($pattern, $replacement, $config);
            file_put_contents($configPath, $config);
        }
    }

    /**
     * Create database backup
     */
    public function createBackup()
    {
        try {
            $databaseName = config('database.connections.mysql.database');
            $backupDir = storage_path('app/backups');
            
            if (!File::exists($backupDir)) {
                File::makeDirectory($backupDir, 0755, true);
            }
            
            $backupFileName = 'backup_' . date('Y-m-d_His') . '.sql';
            $backupPath = $backupDir . '/' . $backupFileName;
            
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                escapeshellarg(config('database.connections.mysql.username')),
                escapeshellarg(config('database.connections.mysql.password')),
                escapeshellarg(config('database.connections.mysql.host')),
                escapeshellarg($databaseName),
                escapeshellarg($backupPath)
            );
            
            exec($command, $output, $returnVar);
            
            if ($returnVar === 0 && File::exists($backupPath)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Backup created successfully: ' . $backupFileName
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create backup. Please check database credentials and mysqldump availability.'
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Backup Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating backup: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear application cache
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'Cache cleared successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Clear Cache Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error clearing cache: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update system (run migrations)
     */
    public function updateSystem()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'System updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Update System Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating system: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset settings to default
     */
    public function resetSettings()
    {
        try {
            // Delete all settings except essential ones
            Setting::whereNotIn('key', ['favicon', 'logo'])->delete();
            
            // Reset to default values
            Setting::set('store_name', 'A R Electronics');
            Setting::set('store_email', 'info@arelectronics.com');
            Setting::set('currency', 'INR');
            
            return response()->json([
                'success' => true,
                'message' => 'Settings reset to default successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Reset Settings Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error resetting settings: ' . $e->getMessage()
            ], 500);
        }
    }
}
