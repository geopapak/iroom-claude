-- =====================================================
-- Fix Admin Password Hash
-- =====================================================
-- Updates the default admin password to a verified BCrypt hash
-- Password: admin
-- =====================================================

UPDATE `admin`
SET `pass` = '$2a$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5GyYCjY9qMvqm'
WHERE `email` = 'admin@iroom.gr';
