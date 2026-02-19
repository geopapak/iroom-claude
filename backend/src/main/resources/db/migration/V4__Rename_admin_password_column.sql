-- =====================================================
-- V4: Rename admin 'password' column to 'pass'
-- =====================================================
-- Background
-- ----------
-- The original (pre-Spring Boot) database used 'password' as the column
-- name in the admin table. The Admin JPA entity declares:
--
--   @Column(name = "pass", nullable = false, length = 255)
--   private String passwordHash;
--
-- so Hibernate schema validation fails at startup:
--   "Schema-validation: missing column [pass] in table [admin]"
--
-- V2 uses CREATE TABLE IF NOT EXISTS, which silently skips tables that
-- already exist. This leaves the legacy 'password' column in place.
--
-- What this migration does
-- ------------------------
-- * Checks whether the admin table still has a 'password' column and
--   does NOT yet have a 'pass' column.
-- * If so, it renames 'password' -> 'pass' using ALTER TABLE CHANGE.
-- * Otherwise it executes a harmless SELECT 1 (no-op).
--
-- This migration is therefore safe on both:
--   - Legacy databases  : renames 'password' -> 'pass'
--   - Fresh databases   : 'pass' already exists from V2, no change made
-- =====================================================

-- Step 1: detect column layout
SET @schema_name = DATABASE();

SELECT COUNT(*) INTO @has_password_col
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = @schema_name
  AND TABLE_NAME   = 'admin'
  AND COLUMN_NAME  = 'password';

SELECT COUNT(*) INTO @has_pass_col
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = @schema_name
  AND TABLE_NAME   = 'admin'
  AND COLUMN_NAME  = 'pass';

-- Step 2: build the statement to execute
SET @rename_sql = IF(
    @has_password_col > 0 AND @has_pass_col = 0,
    'ALTER TABLE `admin` CHANGE `password` `pass` VARCHAR(255) NOT NULL',
    'SELECT 1'
);

-- Step 3: execute conditionally
PREPARE migration_stmt FROM @rename_sql;
EXECUTE migration_stmt;
DEALLOCATE PREPARE migration_stmt;
