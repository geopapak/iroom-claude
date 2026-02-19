-- =====================================================
-- V6: Rename admin.pass column to admin.password
-- =====================================================
-- Hibernate schema validation expects column 'password'
-- in the admin table (based on field name convention).
-- This migration renames the 'pass' column to 'password'.
-- =====================================================

ALTER TABLE `admin` CHANGE `pass` `password` VARCHAR(255) NOT NULL;
