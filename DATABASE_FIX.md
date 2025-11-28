# Database Connection Error Fix

## Error
```
SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it
```

## Solution

### Step 1: Start MySQL in WAMP
1. Open WAMP Server
2. Click on the WAMP icon in system tray
3. Make sure MySQL service is **GREEN** (running)
4. If it's RED, click "Start All Services"

### Step 2: Check/Update .env File
Create or update `.env` file in the root directory with:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=raju
DB_USERNAME=root
DB_PASSWORD=
```

**Note:** 
- For WAMP, the default MySQL username is `root` with no password
- Replace `raju` with your actual database name if different

### Step 3: Verify Database Exists
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Check if database `raju` exists
3. If not, create it:
   ```sql
   CREATE DATABASE raju;
   ```

### Step 4: Run Migrations
```bash
php artisan migrate
```

### Step 5: Test Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

If this returns a PDO object, the connection is working!

### Alternative: Use SQLite (No MySQL needed)
If you want to use SQLite instead:

1. Update `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=C:/wamp64/www/raju/database/database.sqlite
```

2. Create the SQLite file if it doesn't exist:
```bash
touch database/database.sqlite
```

3. Run migrations:
```bash
php artisan migrate
```

## Quick Fix Commands

```bash
# Clear config cache
php artisan config:clear

# Test database connection
php artisan db:show

# Check if MySQL is accessible
php artisan tinker
>>> DB::connection()->getPdo();
```

