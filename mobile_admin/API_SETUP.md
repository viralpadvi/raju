# API Setup Guide

## Configuring the Backend URL

The Flutter admin app needs to connect to your Laravel backend. By default, it's configured to use:
- `http://localhost/api/admin` (for WAMP/Apache on port 80)

## Option 1: Using WAMP (Default Port 80)
If your Laravel app is running on WAMP (default port 80), the default configuration should work:
```
http://localhost/api/admin
```

## Option 2: Using Laravel Development Server (Port 8000)
If you're using `php artisan serve` (runs on port 8000), run the Flutter app with:
```bash
flutter run -d chrome --dart-define=API_BASE_URL=http://localhost:8000/api/admin
```

## Option 3: Custom URL
For any other URL, use:
```bash
flutter run -d chrome --dart-define=API_BASE_URL=YOUR_API_URL
```

## Troubleshooting Connection Errors

### Error: "Cannot connect to server"

1. **Check if Laravel backend is running:**
   - For WAMP: Make sure Apache is running
   - For Laravel dev server: Run `php artisan serve`

2. **Verify the API endpoint:**
   - Test in browser: `http://localhost/api/admin/auth/login` (should return 405 Method Not Allowed, not 404)
   - If 404, check your Laravel routes

3. **Check CORS configuration:**
   - File: `config/cors.php`
   - Should have `'allowed_origins' => ['*']` for development
   - Make sure `'paths' => ['api/*', 'sanctum/csrf-cookie']` includes your API routes

4. **Update API URL in code:**
   - File: `lib/src/core/network/api_client.dart`
   - Change `_defaultBase` constant to match your backend URL

## Testing the Connection

1. Start your Laravel backend
2. Run the Flutter app: `flutter run -d chrome`
3. Try logging in with your admin credentials

## Common Issues

### CORS Errors
If you see CORS errors in the browser console:
- Update `config/cors.php` to allow your Flutter app origin
- For development, you can set `'allowed_origins' => ['*']`

### 404 Not Found
- Check that your Laravel routes are properly configured
- Verify the API prefix matches: `/api/admin/`

### Connection Timeout
- Ensure your backend server is running
- Check firewall settings
- Verify the port number is correct

