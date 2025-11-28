# Laravel API 500 Error - Troubleshooting Guide

## Quick Fixes

### 1. Update CORS Configuration
The CORS is already configured, but ensure `config/cors.php` has:
```php
'allowed_origins' => ['*'],
'supports_credentials' => true,
```

### 2. Check Laravel Logs
Check the error in: `storage/logs/laravel.log`

Common causes:
- Database connection issues
- Missing environment variables
- Sanctum configuration issues

### 3. Verify Database Connection
Check your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Check Sanctum Configuration
Ensure Sanctum is properly installed:
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### 5. Clear Laravel Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### 6. Check User Model
Ensure the User model has the `HasApiTokens` trait:
```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // ...
}
```

### 7. Verify API Route
Test the endpoint directly:
```bash
curl -X POST http://127.0.0.1:8000/api/admin/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@electro.com","password":"your_password","device_name":"test"}'
```

### 8. Check Middleware
Ensure the API routes don't have CSRF protection (they shouldn't for API routes).

## Common 500 Error Causes

1. **Database Connection Failed**
   - Check `.env` database credentials
   - Ensure MySQL is running (if using WAMP)

2. **Missing Sanctum Tables**
   - Run: `php artisan migrate`

3. **User Model Issues**
   - Check if User model has `HasApiTokens` trait
   - Verify the `role` column exists in users table

4. **Environment Variables**
   - Check `APP_DEBUG=true` in `.env` for detailed errors
   - Verify `APP_KEY` is set

## Testing the API

1. Start Laravel server:
   ```bash
   php artisan serve --host=127.0.0.1 --port=8000
   ```

2. Test with Postman or curl:
   ```bash
   POST http://127.0.0.1:8000/api/admin/auth/login
   Content-Type: application/json
   
   {
     "email": "admin@electro.com",
     "password": "password",
     "device_name": "test"
   }
   ```

3. Check response - should return 200 with token, not 500

