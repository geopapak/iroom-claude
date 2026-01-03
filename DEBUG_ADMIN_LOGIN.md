# Debug: Check Admin User Creation

## Step 1: Verify admin user exists in database

Open your MySQL client (phpMyAdmin or command line) and run:

```sql
-- Check if admin user exists
SELECT * FROM admin WHERE email = 'admin@iroom.gr';

-- Check all admin users
SELECT ID, name, last_name, email, user_type FROM admin;
```

## Step 2: Verify the password hash

The current password hash in the database should be:
```
$2a$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy
```

**If the admin user doesn't exist:**
- The Flyway migration V2 didn't run
- Check Flyway history: `SELECT * FROM flyway_schema_history;`
- Restart the application to trigger migration

**If the admin user exists but password doesn't work:**
The BCrypt hash might be incorrect. We need to update it.

## Step 3: Update password manually (if needed)

If the password hash is wrong, run this SQL to set a known good password:

```sql
-- This sets password to: admin123
UPDATE admin
SET pass = '$2a$10$dXJ3SW6G7P50lGmMkkmwe.20cyhh5f6.CzK.4B5wAtH6L9gCrCHqO'
WHERE email = 'admin@iroom.gr';
```

Then try logging in with:
- Email: `admin@iroom.gr`
- Password: `admin123`

## Alternative: Generate a new password hash

If you want to set your own password, you can generate a BCrypt hash:

1. Go to: https://bcrypt-generator.com/
2. Enter your desired password
3. Use the generated hash (starting with $2a$ or $2y$)
4. Update the database:

```sql
UPDATE admin
SET pass = 'YOUR_GENERATED_HASH_HERE'
WHERE email = 'admin@iroom.gr';
```

## Check Application Logs

Look for these messages in your Spring Boot logs:
- "Flyway: Migrating schema" - Shows migration ran
- "Successfully applied 1 migration" - Confirms V2 ran
- UserDetailsService loading user - Shows authentication attempt

Let me know what you find and I can help fix the issue!
