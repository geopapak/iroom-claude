-- =====================================================
-- Database Diagnostic Commands
-- Run these SQL commands to diagnose the login issue
-- =====================================================

-- 1. Check if admin user exists and view password hash
SELECT ID, name, last_name, email, user_type, pass
FROM admin
WHERE email = 'admin@iroom.gr';

-- Expected result:
-- pass should be: $2a$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5GyYCjY9qMvqm


-- 2. Check Flyway migration history to see which migrations have run
SELECT installed_rank, version, description, type, script, installed_on, success
FROM flyway_schema_history
ORDER BY installed_rank;

-- Expected result:
-- Should show V1__Initial_baseline, V2__Create_all_tables, and V3__Fix_admin_password


-- 3. If V3 hasn't run or password is still wrong, fix it manually:
UPDATE admin
SET pass = '$2a$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5GyYCjY9qMvqm'
WHERE email = 'admin@iroom.gr';

-- Then verify the update:
SELECT ID, name, email, pass FROM admin WHERE email = 'admin@iroom.gr';
