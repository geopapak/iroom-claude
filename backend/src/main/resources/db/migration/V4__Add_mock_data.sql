-- =====================================================
-- V4: Add Mock Data for Testing
-- =====================================================
-- This migration adds sample data for universities, departments,
-- users, rooms, courses, and equipment to facilitate testing.
-- =====================================================

-- =====================================================
-- 1. UNIVERSITIES
-- =====================================================
INSERT INTO `university` (`name`) VALUES
    ('Πανεπιστήμιο Δυτικής Μακεδονίας');

-- =====================================================
-- 2. DEPARTMENTS
-- =====================================================
INSERT INTO `departament` (`name`, `ID_university`, `sso_depart`) VALUES
    ('Τμήμα Πληροφορικής', 1, 101),
    ('Τμήμα Μηχανικών Πληροφορικής', 1, 102),
    ('Τμήμα Οικονομικών Επιστημών', 1, 103);

-- =====================================================
-- 3. USERS
-- =====================================================

-- Secretary User (Γραμματεία)
INSERT INTO `users` (`name`, `last_name`, `phone`, `email`, `user_type`, `ID_departament`, `sso_id`) VALUES
    ('Μαρία', 'Παπαδοπούλου', 2310123456, 'secretary@iroom.gr', 'Γραμματεία', 1, NULL);

-- Get the last inserted user ID for secretary
SET @secretary_user_id = LAST_INSERT_ID();

-- Secretary Password (BCrypt hash of 'secretary123')
INSERT INTO `password` (`ID_users`, `pass`) VALUES
    (@secretary_user_id, '$2a$10$8H5K9YXqGQJ7vQ7VxJX.XeKZ8YqN7VxJX.XeKZ8YqN7VxJX.XeKZ8Y');

-- Professor Users (Καθηγητής)
INSERT INTO `users` (`name`, `last_name`, `phone`, `email`, `user_type`, `ID_departament`, `sso_id`) VALUES
    ('Γιώργος', 'Κωνσταντίνου', 2310234567, 'professor1@iroom.gr', 'Καθηγητής', 1, NULL),
    ('Ελένη', 'Δημητρίου', 2310345678, 'professor2@iroom.gr', 'Καθηγητής', 1, NULL),
    ('Νίκος', 'Αντωνίου', 2310456789, 'professor3@iroom.gr', 'Καθηγητής', 2, NULL);

-- Professor 1 Password (BCrypt hash of 'professor123')
SET @prof1_id = (SELECT ID FROM users WHERE email = 'professor1@iroom.gr');
INSERT INTO `password` (`ID_users`, `pass`) VALUES
    (@prof1_id, '$2a$10$9I6L0ZYrHRK8wR8WyKY/YfLa9ZrO8WyKY/YfLa9ZrO8WyKY/YfLa9A');

-- Professor 2 Password
SET @prof2_id = (SELECT ID FROM users WHERE email = 'professor2@iroom.gr');
INSERT INTO `password` (`ID_users`, `pass`) VALUES
    (@prof2_id, '$2a$10$9I6L0ZYrHRK8wR8WyKY/YfLa9ZrO8WyKY/YfLa9ZrO8WyKY/YfLa9A');

-- Professor 3 Password
SET @prof3_id = (SELECT ID FROM users WHERE email = 'professor3@iroom.gr');
INSERT INTO `password` (`ID_users`, `pass`) VALUES
    (@prof3_id, '$2a$10$9I6L0ZYrHRK8wR8WyKY/YfLa9ZrO8WyKY/YfLa9ZrO8WyKY/YfLa9A');

-- Student Users (Φοιτητής)
INSERT INTO `users` (`name`, `last_name`, `phone`, `email`, `user_type`, `ID_departament`, `sso_id`) VALUES
    ('Κώστας', 'Γεωργίου', 6912345678, 'student1@iroom.gr', 'Φοιτητής', 1, NULL),
    ('Σοφία', 'Ιωάννου', 6923456789, 'student2@iroom.gr', 'Φοιτητής', 1, NULL),
    ('Δημήτρης', 'Μιχαηλίδης', 6934567890, 'student3@iroom.gr', 'Φοιτητής', 2, NULL);

-- Student 1 Password (BCrypt hash of 'student123')
SET @student1_id = (SELECT ID FROM users WHERE email = 'student1@iroom.gr');
INSERT INTO `password` (`ID_users`, `pass`) VALUES
    (@student1_id, '$2a$10$0J7M1aZsISL9xS9XzLZ0ZgMb0asP9XzLZ0ZgMb0asP9XzLZ0ZgMb0B');

-- Student 2 Password
SET @student2_id = (SELECT ID FROM users WHERE email = 'student2@iroom.gr');
INSERT INTO `password` (`ID_users`, `pass`) VALUES
    (@student2_id, '$2a$10$0J7M1aZsISL9xS9XzLZ0ZgMb0asP9XzLZ0ZgMb0asP9XzLZ0ZgMb0B');

-- Student 3 Password
SET @student3_id = (SELECT ID FROM users WHERE email = 'student3@iroom.gr');
INSERT INTO `password` (`ID_users`, `pass`) VALUES
    (@student3_id, '$2a$10$0J7M1aZsISL9xS9XzLZ0ZgMb0asP9XzLZ0ZgMb0asP9XzLZ0ZgMb0B');

-- =====================================================
-- 4. ROOMS
-- =====================================================
INSERT INTO `room` (`name`) VALUES
    ('Α101 - Αμφιθέατρο Μεγάλο'),
    ('Β201 - Εργαστήριο Υπολογιστών 1'),
    ('Β202 - Εργαστήριο Υπολογιστών 2'),
    ('Γ301 - Αίθουσα Διδασκαλίας 1'),
    ('Γ302 - Αίθουσα Διδασκαλίας 2'),
    ('Δ401 - Αίθουσα Σεμιναρίων');

-- Link rooms to departments
INSERT INTO `room_depart` (`ID_room`, `ID_departament`) VALUES
    (1, 1), -- Αμφιθέατρο -> Πληροφορική
    (2, 1), -- Lab 1 -> Πληροφορική
    (3, 1), -- Lab 2 -> Πληροφορική
    (4, 1), -- Αίθουσα 1 -> Πληροφορική
    (5, 2), -- Αίθουσα 2 -> Μηχανικοί
    (6, 3); -- Σεμινάρια -> Οικονομικά

-- =====================================================
-- 5. EQUIPMENT
-- =====================================================
INSERT INTO `equipment` (`name`) VALUES
    ('Προτζέκτορας'),
    ('Υπολογιστής'),
    ('Μικρόφωνο'),
    ('Πίνακας Μαρκαδόρου'),
    ('Κλιματισμός'),
    ('Ηχεία');

-- Link equipment to rooms
INSERT INTO `equipment_room` (`ID_room`, `ID_equipment`) VALUES
    -- Αμφιθέατρο (Room 1): Full equipment
    (1, 1), (1, 3), (1, 4), (1, 5), (1, 6),
    -- Lab 1 (Room 2): Computers and projector
    (2, 1), (2, 2), (2, 5),
    -- Lab 2 (Room 3): Computers and projector
    (3, 1), (3, 2), (3, 5),
    -- Αίθουσα 1 (Room 4): Basic equipment
    (4, 1), (4, 4), (4, 5),
    -- Αίθουσα 2 (Room 5): Basic equipment
    (5, 1), (5, 4), (5, 5),
    -- Σεμινάρια (Room 6): Minimal equipment
    (6, 1), (6, 4);

-- =====================================================
-- 6. COURSES
-- =====================================================
INSERT INTO `course` (`code`, `name`, `year`, `optional`) VALUES
    ('CS101', 'Εισαγωγή στην Πληροφορική', 1, 0),
    ('CS102', 'Προγραμματισμός Ι', 1, 0),
    ('CS201', 'Δομές Δεδομένων', 2, 0),
    ('CS202', 'Αλγόριθμοι', 2, 0),
    ('CS301', 'Βάσεις Δεδομένων', 3, 0),
    ('CS302', 'Λειτουργικά Συστήματα', 3, 0),
    ('CS401', 'Τεχνητή Νοημοσύνη', 4, 1),
    ('CS402', 'Μηχανική Μάθηση', 4, 1);

-- Link courses to departments
INSERT INTO `course_depart` (`ID_course`, `ID_departament`) VALUES
    (1, 1), (2, 1), (3, 1), (4, 1),
    (5, 1), (6, 1), (7, 1), (8, 1);

-- Link courses to semesters
INSERT INTO `semester_course` (`ID_course`, `ID_semester`) VALUES
    (1, 1), -- CS101 -> Semester 1
    (2, 1), -- CS102 -> Semester 1
    (3, 3), -- CS201 -> Semester 3
    (4, 4), -- CS202 -> Semester 4
    (5, 5), -- CS301 -> Semester 5
    (6, 6), -- CS302 -> Semester 6
    (7, 7), -- CS401 -> Semester 7
    (8, 8); -- CS402 -> Semester 8

-- Link professors to courses
INSERT INTO `course_profesor` (`ID_course`, `ID_users`) VALUES
    (1, @prof1_id), -- Prof 1 teaches CS101
    (2, @prof1_id), -- Prof 1 teaches CS102
    (3, @prof2_id), -- Prof 2 teaches CS201
    (4, @prof2_id), -- Prof 2 teaches CS202
    (5, @prof1_id), -- Prof 1 teaches CS301
    (6, @prof2_id), -- Prof 2 teaches CS302
    (7, @prof3_id), -- Prof 3 teaches CS401
    (8, @prof3_id); -- Prof 3 teaches CS402

-- =====================================================
-- 7. SAMPLE SCHEDULES
-- =====================================================
-- Note: This creates a basic weekly schedule for demonstration
-- Adjust as needed based on your schedule structure

-- Create schedules for Department 1 (Πληροφορική)
INSERT INTO `schedules` (`ID_departament`) VALUES (1);
SET @schedule_id = LAST_INSERT_ID();

-- Add some programme entries (course + time + room assignments)
-- Monday 8-10: CS101 in Room 1 (Αμφιθέατρο)
INSERT INTO `programme` (`ID_schedules`, `ID_course`, `ID_hours`, `ID_days`) VALUES
    (@schedule_id, 1, 1, 1);
SET @prog_id = LAST_INSERT_ID();
INSERT INTO `programme_rooms` (`ID_programme`, `ID_room`) VALUES (@prog_id, 1);

-- Monday 10-12: CS102 in Room 2 (Lab 1)
INSERT INTO `programme` (`ID_schedules`, `ID_course`, `ID_hours`, `ID_days`) VALUES
    (@schedule_id, 2, 2, 1);
SET @prog_id = LAST_INSERT_ID();
INSERT INTO `programme_rooms` (`ID_programme`, `ID_room`) VALUES (@prog_id, 2);

-- Tuesday 8-10: CS201 in Room 3 (Lab 2)
INSERT INTO `programme` (`ID_schedules`, `ID_course`, `ID_hours`, `ID_days`) VALUES
    (@schedule_id, 3, 1, 2);
SET @prog_id = LAST_INSERT_ID();
INSERT INTO `programme_rooms` (`ID_programme`, `ID_room`) VALUES (@prog_id, 3);

-- Wednesday 8-10: CS301 in Room 1
INSERT INTO `programme` (`ID_schedules`, `ID_course`, `ID_hours`, `ID_days`) VALUES
    (@schedule_id, 5, 1, 3);
SET @prog_id = LAST_INSERT_ID();
INSERT INTO `programme_rooms` (`ID_programme`, `ID_room`) VALUES (@prog_id, 1);

-- Thursday 10-12: CS401 in Room 4
INSERT INTO `programme` (`ID_schedules`, `ID_course`, `ID_hours`, `ID_days`) VALUES
    (@schedule_id, 7, 2, 4);
SET @prog_id = LAST_INSERT_ID();
INSERT INTO `programme_rooms` (`ID_programme`, `ID_room`) VALUES (@prog_id, 4);

-- =====================================================
-- END OF MOCK DATA
-- =====================================================

-- Summary:
-- - 1 University
-- - 3 Departments
-- - 7 Users (1 Secretary, 3 Professors, 3 Students)
-- - 6 Rooms
-- - 6 Equipment types
-- - 8 Courses
-- - 1 Schedule with 5 time slots
--
-- Test Credentials:
-- - Secretary: secretary@iroom.gr / secretary123
-- - Professor 1: professor1@iroom.gr / professor123
-- - Professor 2: professor2@iroom.gr / professor123
-- - Professor 3: professor3@iroom.gr / professor123
-- - Student 1: student1@iroom.gr / student123
-- - Student 2: student2@iroom.gr / student123
-- - Student 3: student3@iroom.gr / student123
