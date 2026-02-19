-- =====================================================
-- V6: Ensure the default admin user exists
-- =====================================================
-- On fresh databases V2 already inserted admin@iroom.gr (this is a no-op).
-- On legacy databases V2's INSERT failed because the column was named
-- 'password' rather than 'pass'. V4 has since renamed the column to 'pass',
-- so this migration can safely re-run the INSERT.
--
-- Default credentials:
--   Email   : admin@iroom.gr
--   Password: admin
-- IMPORTANT: Change the password after first login!
-- =====================================================

INSERT INTO `admin` (`name`, `last_name`, `phone`, `email`, `user_type`, `pass`)
VALUES (
    'Admin',
    'User',
    NULL,
    'admin@iroom.gr',
    'Διαχειριστής',
    '$2a$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5GyYCjY9qMvqm'
)
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`);
