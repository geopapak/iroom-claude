-- =====================================================
-- iRoom Database - Complete Schema Creation
-- Version: 2.0.0
-- Description: Creates all 30 tables for the iRoom system
-- =====================================================

-- Set character set for Greek language support
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- =====================================================
-- Core Tables (no dependencies)
-- =====================================================

-- University table
CREATE TABLE IF NOT EXISTS `university` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Semester table (1st, 2nd, 3rd, etc.)
CREATE TABLE IF NOT EXISTS `semester` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Equipment table
CREATE TABLE IF NOT EXISTS `equipment` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Days table (weekdays)
CREATE TABLE IF NOT EXISTS `days` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Hours table (time slots)
CREATE TABLE IF NOT EXISTS `hours` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `start_hour` INT NOT NULL,
    `end_hour` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schedules table (academic years like "2023-2024")
CREATE TABLE IF NOT EXISTS `schedules` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exam days table
CREATE TABLE IF NOT EXISTS `exam_days` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User type table
CREATE TABLE IF NOT EXISTS `type_user` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `type` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin table (system administrators)
CREATE TABLE IF NOT EXISTS `admin` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `phone` VARCHAR(50),
    `email` VARCHAR(25) NOT NULL UNIQUE,
    `user_type` VARCHAR(25) NOT NULL,
    `pass` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Rooms table
CREATE TABLE IF NOT EXISTS `rooms` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Course table
CREATE TABLE IF NOT EXISTS `course` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `year` INT NOT NULL,
    `code` VARCHAR(20) NOT NULL,
    `optional` VARCHAR(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Tables with Level 1 Dependencies
-- =====================================================

-- Department table (note: spelled as "departament" in original)
CREATE TABLE IF NOT EXISTS `departament` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `ID_university` BIGINT NOT NULL,
    `sso_depart` INT NOT NULL,
    CONSTRAINT `fk_departament_university`
        FOREIGN KEY (`ID_university`) REFERENCES `university`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_departament_university` ON `departament`(`ID_university`);

-- =====================================================
-- Tables with Level 2 Dependencies
-- =====================================================

-- Users table (professors, students, secretariat)
CREATE TABLE IF NOT EXISTS `users` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(25) NOT NULL,
    `last_name` VARCHAR(25) NOT NULL,
    `phone` INT,
    `email` VARCHAR(25) NOT NULL UNIQUE,
    `ID_departament` BIGINT NOT NULL,
    `user_type` VARCHAR(25) NOT NULL,
    `sso_id` VARCHAR(255),
    CONSTRAINT `fk_users_departament`
        FOREIGN KEY (`ID_departament`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_users_departament` ON `users`(`ID_departament`);
CREATE INDEX `idx_users_email` ON `users`(`email`);

-- Password table (user authentication)
CREATE TABLE IF NOT EXISTS `password` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_user` BIGINT NOT NULL UNIQUE,
    `pass` VARCHAR(255) NOT NULL,
    CONSTRAINT `fk_password_user`
        FOREIGN KEY (`ID_user`) REFERENCES `users`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_password_user` ON `password`(`ID_user`);

-- Kateuthinsi table (academic tracks/specializations)
CREATE TABLE IF NOT EXISTS `kateuthinsi` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `ID_department` BIGINT NOT NULL,
    CONSTRAINT `fk_kateuthinsi_department`
        FOREIGN KEY (`ID_department`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_kateuthinsi_department` ON `kateuthinsi`(`ID_department`);

-- Semester Course table (links courses to semesters and departments)
CREATE TABLE IF NOT EXISTS `semester_course` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_course` BIGINT NOT NULL,
    `ID_semester` BIGINT NOT NULL,
    `ID_depart` BIGINT NOT NULL,
    CONSTRAINT `fk_semester_course_course`
        FOREIGN KEY (`ID_course`) REFERENCES `course`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_semester_course_semester`
        FOREIGN KEY (`ID_semester`) REFERENCES `semester`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_semester_course_depart`
        FOREIGN KEY (`ID_depart`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_semester_course_course` ON `semester_course`(`ID_course`);
CREATE INDEX `idx_semester_course_semester` ON `semester_course`(`ID_semester`);
CREATE INDEX `idx_semester_course_depart` ON `semester_course`(`ID_depart`);

-- Course Professor table (note: spelled as "course_profesor" in original)
CREATE TABLE IF NOT EXISTS `course_profesor` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_course` BIGINT NOT NULL,
    `ID_profesor` BIGINT NOT NULL,
    `ID_depart` BIGINT NOT NULL,
    CONSTRAINT `fk_course_profesor_course`
        FOREIGN KEY (`ID_course`) REFERENCES `course`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_course_profesor_user`
        FOREIGN KEY (`ID_profesor`) REFERENCES `users`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_course_profesor_depart`
        FOREIGN KEY (`ID_depart`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_course_profesor_course` ON `course_profesor`(`ID_course`);
CREATE INDEX `idx_course_profesor_user` ON `course_profesor`(`ID_profesor`);
CREATE INDEX `idx_course_profesor_depart` ON `course_profesor`(`ID_depart`);

-- Course Department table
CREATE TABLE IF NOT EXISTS `course_depart` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_course` BIGINT NOT NULL,
    `ID_departament` BIGINT NOT NULL,
    CONSTRAINT `fk_course_depart_course`
        FOREIGN KEY (`ID_course`) REFERENCES `course`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_course_depart_departament`
        FOREIGN KEY (`ID_departament`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_course_depart_course` ON `course_depart`(`ID_course`);
CREATE INDEX `idx_course_depart_departament` ON `course_depart`(`ID_departament`);

-- Course Kateuthinsi table
CREATE TABLE IF NOT EXISTS `course_kateuthinsi` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_course` BIGINT NOT NULL,
    `ID_kat` BIGINT NOT NULL,
    `ID_department` BIGINT NOT NULL,
    CONSTRAINT `fk_course_kateuthinsi_course`
        FOREIGN KEY (`ID_course`) REFERENCES `course`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_course_kateuthinsi_kat`
        FOREIGN KEY (`ID_kat`) REFERENCES `kateuthinsi`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_course_kateuthinsi_department`
        FOREIGN KEY (`ID_department`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_course_kateuthinsi_course` ON `course_kateuthinsi`(`ID_course`);
CREATE INDEX `idx_course_kateuthinsi_kat` ON `course_kateuthinsi`(`ID_kat`);
CREATE INDEX `idx_course_kateuthinsi_department` ON `course_kateuthinsi`(`ID_department`);

-- Equipment Room table
CREATE TABLE IF NOT EXISTS `equipment_room` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_rooms` BIGINT NOT NULL,
    `ID_equipment` BIGINT NOT NULL,
    `ID_departament` BIGINT NOT NULL,
    CONSTRAINT `fk_equipment_room_room`
        FOREIGN KEY (`ID_rooms`) REFERENCES `rooms`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_equipment_room_equipment`
        FOREIGN KEY (`ID_equipment`) REFERENCES `equipment`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_equipment_room_departament`
        FOREIGN KEY (`ID_departament`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_equipment_room_room` ON `equipment_room`(`ID_rooms`);
CREATE INDEX `idx_equipment_room_equipment` ON `equipment_room`(`ID_equipment`);
CREATE INDEX `idx_equipment_room_departament` ON `equipment_room`(`ID_departament`);

-- Room Department table
CREATE TABLE IF NOT EXISTS `room_depart` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_room` BIGINT NOT NULL,
    `ID_departament` BIGINT NOT NULL,
    CONSTRAINT `fk_room_depart_room`
        FOREIGN KEY (`ID_room`) REFERENCES `rooms`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_room_depart_departament`
        FOREIGN KEY (`ID_departament`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_room_depart_room` ON `room_depart`(`ID_room`);
CREATE INDEX `idx_room_depart_departament` ON `room_depart`(`ID_departament`);

-- Equipment Department table
CREATE TABLE IF NOT EXISTS `equipment_depart` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_equipment` BIGINT NOT NULL,
    `ID_departament` BIGINT NOT NULL,
    CONSTRAINT `fk_equipment_depart_equipment`
        FOREIGN KEY (`ID_equipment`) REFERENCES `equipment`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_equipment_depart_departament`
        FOREIGN KEY (`ID_departament`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_equipment_depart_equipment` ON `equipment_depart`(`ID_equipment`);
CREATE INDEX `idx_equipment_depart_departament` ON `equipment_depart`(`ID_departament`);

-- My Course table (student course selections)
CREATE TABLE IF NOT EXISTS `my_course` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_user` BIGINT NOT NULL,
    `ID_course` BIGINT NOT NULL,
    CONSTRAINT `fk_my_course_user`
        FOREIGN KEY (`ID_user`) REFERENCES `users`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_my_course_course`
        FOREIGN KEY (`ID_course`) REFERENCES `course`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_my_course_user` ON `my_course`(`ID_user`);
CREATE INDEX `idx_my_course_course` ON `my_course`(`ID_course`);

-- Admin Semester table
CREATE TABLE IF NOT EXISTS `admin_sem` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_department` BIGINT NOT NULL,
    `ID_sem` INT NOT NULL,
    CONSTRAINT `fk_admin_sem_department`
        FOREIGN KEY (`ID_department`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_admin_sem_department` ON `admin_sem`(`ID_department`);

-- Notification table (room booking requests)
CREATE TABLE IF NOT EXISTS `notification` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_user` BIGINT NOT NULL,
    `ID_day_hour` INT NOT NULL,
    `ID_departament` BIGINT NOT NULL,
    `ID_course` BIGINT NOT NULL,
    `ID_room` BIGINT NOT NULL,
    `subject` VARCHAR(250) NOT NULL,
    `status` INT NOT NULL,
    CONSTRAINT `fk_notification_user`
        FOREIGN KEY (`ID_user`) REFERENCES `users`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_notification_departament`
        FOREIGN KEY (`ID_departament`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_notification_course`
        FOREIGN KEY (`ID_course`) REFERENCES `course`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_notification_room`
        FOREIGN KEY (`ID_room`) REFERENCES `rooms`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_notification_user` ON `notification`(`ID_user`);
CREATE INDEX `idx_notification_departament` ON `notification`(`ID_departament`);
CREATE INDEX `idx_notification_course` ON `notification`(`ID_course`);
CREATE INDEX `idx_notification_room` ON `notification`(`ID_room`);
CREATE INDEX `idx_notification_status` ON `notification`(`status`);

-- =====================================================
-- Tables with Level 3+ Dependencies (Schedule tables)
-- =====================================================

-- Programme table (class schedule)
CREATE TABLE IF NOT EXISTS `programme` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_semester_course` BIGINT NOT NULL,
    `ID_day` BIGINT NOT NULL,
    `ID_hour` BIGINT NOT NULL,
    `ID_user` BIGINT NOT NULL,
    `ID_schedule` BIGINT NOT NULL,
    CONSTRAINT `fk_programme_semester_course`
        FOREIGN KEY (`ID_semester_course`) REFERENCES `semester_course`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_day`
        FOREIGN KEY (`ID_day`) REFERENCES `days`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_hour`
        FOREIGN KEY (`ID_hour`) REFERENCES `hours`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_user`
        FOREIGN KEY (`ID_user`) REFERENCES `users`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_schedule`
        FOREIGN KEY (`ID_schedule`) REFERENCES `schedules`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_programme_semester_course` ON `programme`(`ID_semester_course`);
CREATE INDEX `idx_programme_day` ON `programme`(`ID_day`);
CREATE INDEX `idx_programme_hour` ON `programme`(`ID_hour`);
CREATE INDEX `idx_programme_user` ON `programme`(`ID_user`);
CREATE INDEX `idx_programme_schedule` ON `programme`(`ID_schedule`);

-- Programme Rooms table
CREATE TABLE IF NOT EXISTS `programme_rooms` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_day_hour` INT,
    `ID_room` BIGINT NOT NULL,
    `ID_course` BIGINT,
    `ID_departament` BIGINT NOT NULL,
    `ID_schedule` BIGINT NOT NULL,
    CONSTRAINT `fk_programme_rooms_room`
        FOREIGN KEY (`ID_room`) REFERENCES `rooms`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_rooms_course`
        FOREIGN KEY (`ID_course`) REFERENCES `course`(`ID`)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_rooms_departament`
        FOREIGN KEY (`ID_departament`) REFERENCES `departament`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_rooms_schedule`
        FOREIGN KEY (`ID_schedule`) REFERENCES `schedules`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_programme_rooms_room` ON `programme_rooms`(`ID_room`);
CREATE INDEX `idx_programme_rooms_course` ON `programme_rooms`(`ID_course`);
CREATE INDEX `idx_programme_rooms_departament` ON `programme_rooms`(`ID_departament`);
CREATE INDEX `idx_programme_rooms_schedule` ON `programme_rooms`(`ID_schedule`);

-- Programme History table
CREATE TABLE IF NOT EXISTS `programme_history` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_semester_course` BIGINT NOT NULL,
    `ID_day` BIGINT NOT NULL,
    `ID_hour` BIGINT NOT NULL,
    `ID_user` BIGINT NOT NULL,
    `ID_schedule` BIGINT NOT NULL,
    `type` VARCHAR(10) NOT NULL,
    CONSTRAINT `fk_programme_history_semester_course`
        FOREIGN KEY (`ID_semester_course`) REFERENCES `semester_course`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_history_day`
        FOREIGN KEY (`ID_day`) REFERENCES `days`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_history_hour`
        FOREIGN KEY (`ID_hour`) REFERENCES `hours`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_history_user`
        FOREIGN KEY (`ID_user`) REFERENCES `users`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_history_schedule`
        FOREIGN KEY (`ID_schedule`) REFERENCES `schedules`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_programme_history_semester_course` ON `programme_history`(`ID_semester_course`);
CREATE INDEX `idx_programme_history_schedule` ON `programme_history`(`ID_schedule`);

-- Programme Rooms History table
CREATE TABLE IF NOT EXISTS `programme_rooms_history` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_day_hour` INT,
    `ID_room` BIGINT NOT NULL,
    `ID_course` BIGINT NOT NULL,
    `ID_schedule` BIGINT NOT NULL,
    CONSTRAINT `fk_programme_rooms_history_room`
        FOREIGN KEY (`ID_room`) REFERENCES `rooms`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_rooms_history_course`
        FOREIGN KEY (`ID_course`) REFERENCES `course`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_programme_rooms_history_schedule`
        FOREIGN KEY (`ID_schedule`) REFERENCES `schedules`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_programme_rooms_history_room` ON `programme_rooms_history`(`ID_room`);
CREATE INDEX `idx_programme_rooms_history_course` ON `programme_rooms_history`(`ID_course`);
CREATE INDEX `idx_programme_rooms_history_schedule` ON `programme_rooms_history`(`ID_schedule`);

-- Exam Programme table
CREATE TABLE IF NOT EXISTS `exam_programme` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_semester_course` BIGINT NOT NULL,
    `ID_day` BIGINT NOT NULL,
    `ID_hour` BIGINT NOT NULL,
    `ID_user` BIGINT NOT NULL,
    `ID_schedule` BIGINT NOT NULL,
    CONSTRAINT `fk_exam_programme_semester_course`
        FOREIGN KEY (`ID_semester_course`) REFERENCES `semester_course`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_exam_programme_day`
        FOREIGN KEY (`ID_day`) REFERENCES `exam_days`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_exam_programme_hour`
        FOREIGN KEY (`ID_hour`) REFERENCES `hours`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_exam_programme_user`
        FOREIGN KEY (`ID_user`) REFERENCES `users`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_exam_programme_schedule`
        FOREIGN KEY (`ID_schedule`) REFERENCES `schedules`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_exam_programme_semester_course` ON `exam_programme`(`ID_semester_course`);
CREATE INDEX `idx_exam_programme_day` ON `exam_programme`(`ID_day`);
CREATE INDEX `idx_exam_programme_schedule` ON `exam_programme`(`ID_schedule`);

-- Exam Programme Rooms table
CREATE TABLE IF NOT EXISTS `exam_programme_rooms` (
    `ID` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `ID_day_hour` INT,
    `ID_room` BIGINT NOT NULL,
    `ID_course` BIGINT,
    `active` VARCHAR(8) NOT NULL,
    CONSTRAINT `fk_exam_programme_rooms_room`
        FOREIGN KEY (`ID_room`) REFERENCES `rooms`(`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_exam_programme_rooms_course`
        FOREIGN KEY (`ID_course`) REFERENCES `course`(`ID`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_exam_programme_rooms_room` ON `exam_programme_rooms`(`ID_room`);
CREATE INDEX `idx_exam_programme_rooms_course` ON `exam_programme_rooms`(`ID_course`);

-- =====================================================
-- Insert Sample Data for Testing (Optional)
-- =====================================================

-- Insert default days (Greek weekdays)
INSERT INTO `days` (`name`) VALUES
    ('Δευτέρα'),
    ('Τρίτη'),
    ('Τετάρτη'),
    ('Πέμπτη'),
    ('Παρασκευή')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Insert default hours (8:00-18:00)
INSERT INTO `hours` (`start_hour`, `end_hour`) VALUES
    (8, 10),
    (10, 12),
    (12, 14),
    (14, 16),
    (16, 18)
ON DUPLICATE KEY UPDATE `start_hour`=VALUES(`start_hour`), `end_hour`=VALUES(`end_hour`);

-- Insert default semesters
INSERT INTO `semester` (`name`) VALUES
    ('1'),
    ('2'),
    ('3'),
    ('4'),
    ('5'),
    ('6'),
    ('7'),
    ('8')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- Insert default user types
INSERT INTO `type_user` (`type`) VALUES
    ('Καθηγητής'),
    ('Φοιτητής'),
    ('Γραμματεία'),
    ('Διαχειριστής')
ON DUPLICATE KEY UPDATE `type`=VALUES(`type`);

-- =====================================================
-- Insert Default Admin User for Initial Login
-- =====================================================
-- Default credentials:
--   Email: admin@iroom.gr
--   Password: admin
-- IMPORTANT: Change this password after first login!
-- =====================================================

INSERT INTO `admin` (`name`, `last_name`, `phone`, `email`, `user_type`, `pass`) VALUES
    (
        'Admin',
        'User',
        NULL,
        'admin@iroom.gr',
        'Διαχειριστής',
        '$2a$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5GyYCjY9qMvqm'
    )
ON DUPLICATE KEY UPDATE `email`=VALUES(`email`);

-- =====================================================
-- Migration Complete
-- =====================================================
-- All 30 tables have been created successfully
-- Database is ready for use with the iRoom application
--
-- Default Login Credentials:
--   Email: admin@iroom.gr
--   Password: admin
--
-- IMPORTANT: Change the default password immediately after first login!
-- =====================================================
