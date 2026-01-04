-- =====================================================
-- Flyway Repair Script
-- =====================================================
-- This script repairs the Flyway schema history after
-- the failed V4 migration.
--
-- Run this in your MySQL database BEFORE starting the backend:
-- mysql -u iroom -p iRoom < FLYWAY_REPAIR.sql
-- (password: iroom)
-- =====================================================

-- Delete the failed V4 migration record
DELETE FROM `flyway_schema_history` WHERE `version` = '4';

-- Verify the schema history is clean
SELECT * FROM `flyway_schema_history` ORDER BY `installed_rank`;

-- Expected output should show:
-- V1, V2, V3 with success=1
-- No V4 entry

-- =====================================================
-- After running this script:
-- 1. Start the backend (mvn spring-boot:run)
-- 2. Flyway will automatically run V5__Add_mock_data.sql
-- 3. All test users will be created
-- =====================================================
