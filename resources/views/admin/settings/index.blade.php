@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 mb-0">Settings</h1>
  <button class="btn btn-primary" type="submit" form="settingsForm">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
      <polyline points="17 21 17 13 7 13 7 21"></polyline>
      <polyline points="7 3 7 8 15 8"></polyline>
    </svg>
    <span>Save Changes</span>
  </button>
</div>

<div class="row">
  <div class="col-lg-8">
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<form id="settingsForm" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')
    <!-- General Settings -->
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">General Settings</h6>
      </div>
      <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Store Name</label>
                <input type="text" name="store_name" class="form-control" value="{{ $settings['store_name'] ?? 'A R Electronics' }}" placeholder="Enter store name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Store Email</label>
                <input type="email" name="store_email" class="form-control" value="{{ $settings['store_email'] ?? 'info@arelectronics.com' }}" placeholder="Enter store email">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="tel" name="store_phone" class="form-control" value="{{ $settings['store_phone'] ?? '' }}" placeholder="Enter phone number">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Currency</label>
                <select name="currency" class="form-select">
                  <option value="INR" {{ ($settings['currency'] ?? 'INR') === 'INR' ? 'selected' : '' }}>INR - Indian Rupee (₹)</option>
                  <option value="USD" {{ ($settings['currency'] ?? '') === 'USD' ? 'selected' : '' }}>USD - US Dollar ($)</option>
                  <option value="EUR" {{ ($settings['currency'] ?? '') === 'EUR' ? 'selected' : '' }}>EUR - Euro (€)</option>
                  <option value="GBP" {{ ($settings['currency'] ?? '') === 'GBP' ? 'selected' : '' }}>GBP - British Pound (£)</option>
                  <option value="CAD" {{ ($settings['currency'] ?? '') === 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar (C$)</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Store GST Number</label>
                <input type="text" name="store_gst_number" class="form-control" value="{{ $settings['store_gst_number'] ?? '' }}" placeholder="e.g. 22AAAAA0000A1Z5">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Store Address</label>
            <textarea name="store_address" class="form-control" rows="3" placeholder="Enter store address">{{ $settings['store_address'] ?? '' }}</textarea>
          </div>
          
          <!-- Favicon and Logo Upload -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Favicon</label>
                <input type="file" name="favicon" class="form-control" accept="image/x-icon,image/png,image/jpeg">
                @if(isset($settings['favicon']) && file_exists(public_path($settings['favicon'])))
                  <div class="mt-2">
                    <img src="{{ asset($settings['favicon']) }}" alt="Favicon" style="max-width: 32px; max-height: 32px;" class="border rounded">
                    <small class="text-muted d-block">Current favicon</small>
                  </div>
                @endif
                <small class="text-muted">Recommended: 32x32px ICO or PNG file</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/png,image/jpeg,image/svg+xml">
                @if(isset($settings['logo']) && Storage::disk('public')->exists($settings['logo']))
                  <div class="mt-2">
                    <img src="{{ Storage::url($settings['logo']) }}" alt="Logo" style="max-width: 150px; max-height: 60px;" class="border rounded">
                    <small class="text-muted d-block">Current logo</small>
                  </div>
                @endif
                <small class="text-muted">Recommended: PNG, JPG, or SVG file (max 2MB)</small>
              </div>
            </div>
          </div>
      </div>
    </div>

    <!-- POS Settings -->
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">POS Settings</h6>
      </div>
      <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Default Tax Rate (%)</label>
                <input type="number" class="form-control" value="8.5" step="0.1" placeholder="Enter tax rate">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Receipt Printer</label>
                <select class="form-select">
                  <option value="thermal">Thermal Printer</option>
                  <option value="laser">Laser Printer</option>
                  <option value="inkjet">Inkjet Printer</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Barcode Scanner</label>
                <select class="form-select">
                  <option value="usb">USB Scanner</option>
                  <option value="bluetooth">Bluetooth Scanner</option>
                  <option value="wireless">Wireless Scanner</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Cash Drawer</label>
                <select class="form-select">
                  <option value="auto">Auto Open</option>
                  <option value="manual">Manual Open</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="autoPrint" checked>
            <label class="form-check-label" for="autoPrint">
              Auto print receipts
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="requireCustomer" checked>
            <label class="form-check-label" for="requireCustomer">
              Require customer information for sales
            </label>
          </div>
      </div>
    </div>

    <!-- Inventory Settings -->
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">Inventory Settings</h6>
      </div>
      <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Low Stock Threshold</label>
                <input type="number" class="form-control" value="10" placeholder="Enter threshold">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Reorder Point</label>
                <input type="number" class="form-control" value="5" placeholder="Enter reorder point">
              </div>
            </div>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="autoReorder" checked>
            <label class="form-check-label" for="autoReorder">
              Enable automatic reorder
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="trackExpiry">
            <label class="form-check-label" for="trackExpiry">
              Track product expiry dates
            </label>
          </div>
      </div>
    </div>

    <!-- SMTP Configuration -->
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">SMTP Email Configuration</h6>
      </div>
      <div class="card-body">
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="smtp_enabled" id="smtpEnabled" value="1" {{ ($smtpSettings['smtp_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="smtpEnabled">
              Enable SMTP
            </label>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">SMTP Host</label>
                <input type="text" name="smtp_host" class="form-control" placeholder="smtp.gmail.com" value="{{ old('smtp_host', $smtpSettings['smtp_host'] ?? config('mail.mailers.smtp.host', '')) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">SMTP Port</label>
                <input type="number" name="smtp_port" class="form-control" placeholder="587" value="{{ old('smtp_port', $smtpSettings['smtp_port'] ?? config('mail.mailers.smtp.port', '587')) }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">SMTP Username</label>
                <input type="text" name="smtp_username" class="form-control" placeholder="your-email@gmail.com" value="{{ old('smtp_username', $smtpSettings['smtp_username'] ?? config('mail.mailers.smtp.username', '')) }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">SMTP Password</label>
                <input type="password" name="smtp_password" class="form-control" placeholder="Your SMTP password (leave blank to keep current)">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Encryption</label>
                <select name="smtp_encryption" class="form-select">
                  <option value="tls" {{ old('smtp_encryption', $smtpSettings['smtp_encryption'] ?? config('mail.mailers.smtp.encryption', 'tls')) === 'tls' ? 'selected' : '' }}>TLS</option>
                  <option value="ssl" {{ old('smtp_encryption', $smtpSettings['smtp_encryption'] ?? config('mail.mailers.smtp.encryption')) === 'ssl' ? 'selected' : '' }}>SSL</option>
                  <option value="" {{ old('smtp_encryption', $smtpSettings['smtp_encryption'] ?? config('mail.mailers.smtp.encryption')) === '' ? 'selected' : '' }}>None</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">From Email</label>
                <input type="email" name="smtp_from_email" class="form-control" placeholder="noreply@example.com" value="{{ old('smtp_from_email', $smtpSettings['smtp_from_email'] ?? config('mail.from.address', '')) }}">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">From Name</label>
            <input type="text" name="smtp_from_name" class="form-control" placeholder="A R Electronics" value="{{ old('smtp_from_name', $smtpSettings['smtp_from_name'] ?? config('mail.from.name', 'A R Electronics')) }}">
          </div>
      </div>
    </div>

    <!-- Payment Gateway Configuration -->
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">Payment Gateway Configuration</h6>
      </div>
      <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Default Payment Gateway</label>
            @php
              $paymentSettings = isset($settings['payment_settings']) ? json_decode($settings['payment_settings'], true) : [];
            @endphp
            <select name="payment_gateway" class="form-select" id="paymentGatewaySelect">
              <option value="stripe" {{ old('payment_gateway', $paymentSettings['payment_gateway'] ?? 'stripe') === 'stripe' ? 'selected' : '' }}>Stripe</option>
              <option value="paypal" {{ old('payment_gateway', $paymentSettings['payment_gateway'] ?? '') === 'paypal' ? 'selected' : '' }}>PayPal</option>
              <option value="razorpay" {{ old('payment_gateway', $paymentSettings['payment_gateway'] ?? '') === 'razorpay' ? 'selected' : '' }}>Razorpay</option>
              <option value="cashfree" {{ old('payment_gateway', $paymentSettings['payment_gateway'] ?? '') === 'cashfree' ? 'selected' : '' }}>Cashfree</option>
              <option value="paytm" {{ old('payment_gateway', $paymentSettings['payment_gateway'] ?? '') === 'paytm' ? 'selected' : '' }}>Paytm</option>
            </select>
          </div>

          <!-- Stripe Configuration -->
          <div class="payment-gateway-config" id="stripeConfig" style="{{ old('payment_gateway', $paymentSettings['payment_gateway'] ?? 'stripe') === 'stripe' ? 'display: block;' : 'display: none;' }}">
            <h6 class="mb-3 text-muted">Stripe Settings</h6>
            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" name="stripe_enabled" id="stripeEnabled" value="1" {{ ($paymentSettings['stripe_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
              <label class="form-check-label" for="stripeEnabled">
                Enable Stripe
              </label>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Publishable Key</label>
                  <input type="text" name="stripe_key" class="form-control" placeholder="pk_test_..." value="{{ old('stripe_key', $paymentSettings['stripe_key'] ?? '') }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Secret Key</label>
                  <input type="password" name="stripe_secret" class="form-control" placeholder="sk_test_... (leave blank to keep current)">
                </div>
              </div>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="stripe_test_mode" id="stripeTestMode" value="1" {{ ($paymentSettings['stripe_test_mode'] ?? '0') === '1' ? 'checked' : '' }}>
              <label class="form-check-label" for="stripeTestMode">
                Test Mode
              </label>
            </div>
          </div>

          <!-- Razorpay Configuration -->
          <div class="payment-gateway-config" id="razorpayConfig" style="{{ old('payment_gateway', $paymentSettings['payment_gateway'] ?? '') === 'razorpay' ? 'display: block;' : 'display: none;' }}">
            <h6 class="mb-3 text-muted">Razorpay Settings</h6>
            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" name="razorpay_enabled" id="razorpayEnabled" value="1" {{ ($paymentSettings['razorpay_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
              <label class="form-check-label" for="razorpayEnabled">
                Enable Razorpay
              </label>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Key ID</label>
                  <input type="text" name="razorpay_key" class="form-control" placeholder="rzp_test_..." value="{{ old('razorpay_key', $paymentSettings['razorpay_key'] ?? '') }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Key Secret</label>
                  <input type="password" name="razorpay_secret" class="form-control" placeholder="Your secret key (leave blank to keep current)">
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>

    <!-- SMS Configuration -->
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">SMS Configuration</h6>
      </div>
      <div class="card-body">
          <div class="mb-3">
            <label class="form-label">SMS Provider</label>
            @php
              $smsSettings = isset($settings['sms_settings']) ? json_decode($settings['sms_settings'], true) : [];
            @endphp
            <select name="sms_provider" class="form-select" id="smsProviderSelect">
              <option value="twilio" {{ old('sms_provider', $smsSettings['sms_provider'] ?? 'twilio') === 'twilio' ? 'selected' : '' }}>Twilio</option>
              <option value="msg91" {{ old('sms_provider', $smsSettings['sms_provider'] ?? '') === 'msg91' ? 'selected' : '' }}>MSG91</option>
              <option value="textlocal" {{ old('sms_provider', $smsSettings['sms_provider'] ?? '') === 'textlocal' ? 'selected' : '' }}>TextLocal</option>
              <option value="nexmo" {{ old('sms_provider', $smsSettings['sms_provider'] ?? '') === 'nexmo' ? 'selected' : '' }}>Vonage (Nexmo)</option>
            </select>
          </div>

          <!-- Twilio Configuration -->
          <div class="sms-provider-config" id="twilioConfig" style="{{ old('sms_provider', $smsSettings['sms_provider'] ?? 'twilio') === 'twilio' ? 'display: block;' : 'display: none;' }}">
            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" name="sms_enabled" id="smsEnabled" value="1" {{ ($smsSettings['sms_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
              <label class="form-check-label" for="smsEnabled">
                Enable SMS Notifications
              </label>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Account SID</label>
                  <input type="text" name="twilio_sid" class="form-control" placeholder="ACxxxxxxxxxxxxx" value="{{ old('twilio_sid', $smsSettings['twilio_sid'] ?? '') }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Auth Token</label>
                  <input type="password" name="twilio_token" class="form-control" placeholder="Your auth token (leave blank to keep current)" value="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">From Number</label>
                  <input type="text" name="twilio_from" class="form-control" placeholder="+1234567890" value="{{ old('twilio_from', $smsSettings['twilio_from'] ?? '') }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Country Code</label>
                  <input type="text" name="sms_country_code" class="form-control" placeholder="+91" value="{{ old('sms_country_code', $smsSettings['sms_country_code'] ?? '+91') }}">
                </div>
              </div>
            </div>
          </div>

          <!-- MSG91 Configuration -->
          <div class="sms-provider-config" id="msg91Config" style="{{ old('sms_provider', $smsSettings['sms_provider'] ?? '') === 'msg91' ? 'display: block;' : 'display: none;' }}">
            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" name="msg91_enabled" id="msg91Enabled" value="1" {{ ($smsSettings['msg91_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
              <label class="form-check-label" for="msg91Enabled">
                Enable MSG91
              </label>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">API Key</label>
                  <input type="text" name="msg91_key" class="form-control" placeholder="Your MSG91 API key" value="{{ old('msg91_key', $smsSettings['msg91_key'] ?? '') }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Sender ID</label>
                  <input type="text" name="msg91_sender" class="form-control" placeholder="ARELEC" value="{{ old('msg91_sender', $smsSettings['msg91_sender'] ?? '') }}">
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <!-- System Information -->
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">System Information</h6>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">Version</span>
            <span class="fw-semibold">v1.0.0</span>
          </div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">Database</span>
            <span class="fw-semibold">MySQL 8.0</span>
          </div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">PHP Version</span>
            <span class="fw-semibold">8.1.0</span>
          </div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">Laravel</span>
            <span class="fw-semibold">10.x</span>
          </div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">Last Backup</span>
            <span class="fw-semibold">Dec 15, 2024</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">Quick Actions</h6>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <button type="button" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" id="createBackupBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" y1="3" x2="12" y2="15"></line>
            </svg>
            <span>Create Backup</span>
          </button>
          <button type="button" class="btn btn-outline-info btn-sm d-flex align-items-center justify-content-center" id="clearCacheBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="1 4 1 10 7 10"></polyline>
              <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
            </svg>
            <span>Clear Cache</span>
          </button>
          <button type="button" class="btn btn-outline-warning btn-sm d-flex align-items-center justify-content-center" id="updateSystemBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="23 4 23 10 17 10"></polyline>
              <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
            </svg>
            <span>Update System</span>
          </button>
          <button type="button" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center" id="resetSettingsBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
            <span>Reset Settings</span>
          </button>
        </div>
      </div>
    </div>

    <!-- User Management -->
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0">User Management</h6>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Active Users</span>
          <span class="badge bg-primary">5</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Admin Users</span>
          <span class="badge bg-success">2</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Cashiers</span>
          <span class="badge bg-info">3</span>
        </div>
        <div class="d-grid gap-2">
          <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>Add User</span>
          </a>
          <a href="{{ route('admin.users.index') }}" class="btn btn-outline-info btn-sm d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Manage Roles</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
</form>

@push('scripts')
<script>
  // Payment Gateway Switching
  document.addEventListener('DOMContentLoaded', function() {
    const paymentGatewaySelect = document.querySelector('select[name="payment_gateway"]');
    if (paymentGatewaySelect) {
      paymentGatewaySelect.addEventListener('change', function() {
        const selected = this.value;
        document.querySelectorAll('.payment-gateway-config').forEach(config => {
          config.style.display = 'none';
        });
        
        if (selected === 'stripe') {
          document.getElementById('stripeConfig').style.display = 'block';
        } else if (selected === 'razorpay') {
          document.getElementById('razorpayConfig').style.display = 'block';
        }
      });
      
      // Trigger on load
      paymentGatewaySelect.dispatchEvent(new Event('change'));
    }

    // SMS Provider Switching
    const smsProviderSelect = document.getElementById('smsProviderSelect');
    if (smsProviderSelect) {
      smsProviderSelect.addEventListener('change', function() {
        const selected = this.value;
        document.querySelectorAll('.sms-provider-config').forEach(config => {
          config.style.display = 'none';
        });
        
        if (selected === 'twilio') {
          document.getElementById('twilioConfig').style.display = 'block';
        } else if (selected === 'msg91') {
          document.getElementById('msg91Config').style.display = 'block';
        }
      });
      
      // Trigger on load
      smsProviderSelect.dispatchEvent(new Event('change'));
    }

    // Quick Actions Buttons
    const createBackupBtn = document.getElementById('createBackupBtn');
    const clearCacheBtn = document.getElementById('clearCacheBtn');
    const updateSystemBtn = document.getElementById('updateSystemBtn');
    const resetSettingsBtn = document.getElementById('resetSettingsBtn');

    if (createBackupBtn) {
      createBackupBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to create a database backup? This may take a few moments.')) {
          this.disabled = true;
          this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating Backup...';
          
          fetch('{{ route("admin.settings.backup") }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Backup created successfully!');
            } else {
              alert('Error: ' + (data.message || 'Failed to create backup'));
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while creating the backup.');
          })
          .finally(() => {
            this.disabled = false;
            this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg><span>Create Backup</span>';
          });
        }
      });
    }

    if (clearCacheBtn) {
      clearCacheBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to clear all cache? This will improve performance but may slow down the next few requests.')) {
          this.disabled = true;
          this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Clearing Cache...';
          
          fetch('{{ route("admin.settings.clear-cache") }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Cache cleared successfully!');
            } else {
              alert('Error: ' + (data.message || 'Failed to clear cache'));
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while clearing the cache.');
          })
          .finally(() => {
            this.disabled = false;
            this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg><span>Clear Cache</span>';
          });
        }
      });
    }

    if (updateSystemBtn) {
      updateSystemBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to update the system? This will run database migrations and may take a few moments.')) {
          this.disabled = true;
          this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating System...';
          
          fetch('{{ route("admin.settings.update-system") }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('System updated successfully!');
            } else {
              alert('Error: ' + (data.message || 'Failed to update system'));
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the system.');
          })
          .finally(() => {
            this.disabled = false;
            this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg><span>Update System</span>';
          });
        }
      });
    }

    if (resetSettingsBtn) {
      resetSettingsBtn.addEventListener('click', function() {
        if (confirm('WARNING: Are you sure you want to reset all settings to default? This action cannot be undone!')) {
          if (confirm('This will delete all your custom settings. Are you absolutely sure?')) {
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Resetting Settings...';
            
            fetch('{{ route("admin.settings.reset") }}', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('Settings reset successfully! The page will reload.');
                window.location.reload();
              } else {
                alert('Error: ' + (data.message || 'Failed to reset settings'));
                this.disabled = false;
                this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg><span>Reset Settings</span>';
              }
            })
            .catch(error => {
              console.error('Error:', error);
              alert('An error occurred while resetting settings.');
              this.disabled = false;
              this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg><span>Reset Settings</span>';
            });
          }
        }
      });
    }
  });
</script>
@endpush
@endsection
