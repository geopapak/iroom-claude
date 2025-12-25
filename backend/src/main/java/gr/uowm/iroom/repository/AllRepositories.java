package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.*;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

// ============================================================================
// BASIC ENTITIES REPOSITORIES
// ============================================================================

@Repository
interface UniversityRepository extends JpaRepository<University, Long> {
    Optional<University> findByName(String name);
}

@Repository
interface DepartmentRepository extends JpaRepository<Department, Long> {
    List<Department> findByUniversityId(Long universityId);
    Optional<Department> findBySsoDepart(Integer ssoDepart);
}

@Repository
interface SemesterRepository extends JpaRepository<Semester, Long> {
    Optional<Semester> findByName(String name);
}

@Repository
interface DayRepository extends JpaRepository<Day, Long> {
    Optional<Day> findByName(String name);
}

@Repository
interface HourRepository extends JpaRepository<Hour, Long> {
    List<Hour> findAllByOrderByStartHourAsc();
}

@Repository
interface ScheduleRepository extends JpaRepository<Schedule, Long> {
    Optional<Schedule> findByName(String name);
    List<Schedule> findAllByOrderByNameDesc();
}

@Repository
interface RoomRepository extends JpaRepository<Room, Long> {
    Optional<Room> findByName(String name);

    @Query("SELECT DISTINCT r FROM Room r JOIN RoomDepart rd ON r.id = rd.room.id WHERE rd.department.id = :departmentId")
    List<Room> findByDepartmentId(@Param("departmentId") Long departmentId);
}

@Repository
interface EquipmentRepository extends JpaRepository<Equipment, Long> {
    Optional<Equipment> findByName(String name);
}

// ============================================================================
// COURSE-RELATED REPOSITORIES
// ============================================================================

@Repository
interface SemesterCourseRepository extends JpaRepository<SemesterCourse, Long> {
    List<SemesterCourse> findBySemesterId(Long semesterId);
    List<SemesterCourse> findByDepartmentId(Long departmentId);
    List<SemesterCourse> findByCourseId(Long courseId);

    @Query("SELECT sc FROM SemesterCourse sc WHERE sc.course.id = :courseId AND sc.semester.id = :semesterId AND sc.department.id = :departmentId")
    Optional<SemesterCourse> findByCourseAndSemesterAndDepartment(
        @Param("courseId") Long courseId,
        @Param("semesterId") Long semesterId,
        @Param("departmentId") Long departmentId
    );
}

@Repository
interface CourseProfessorRepository extends JpaRepository<CourseProfessor, Long> {
    List<CourseProfessor> findByCourseId(Long courseId);
    List<CourseProfessor> findByProfessorId(Long professorId);

    @Query("SELECT cp FROM CourseProfessor cp WHERE cp.course.id = :courseId AND cp.department.id = :departmentId")
    List<CourseProfessor> findByCourseAndDepartment(@Param("courseId") Long courseId, @Param("departmentId") Long departmentId);
}

@Repository
interface KateuthinsiRepository extends JpaRepository<Kateuthinsi, Long> {
    List<Kateuthinsi> findByDepartmentId(Long departmentId);
}

@Repository
interface CourseKateuthinsiRepository extends JpaRepository<CourseKateuthinsi, Long> {
    List<CourseKateuthinsi> findByCourseId(Long courseId);
    List<CourseKateuthinsi> findByKateuthinsiId(Long kateuthinsiId);
}

@Repository
interface CourseDepartRepository extends JpaRepository<CourseDepart, Long> {
    List<CourseDepart> findByCourseId(Long courseId);
    List<CourseDepart> findByDepartmentId(Long departmentId);
}

// ============================================================================
// SCHEDULE REPOSITORIES
// ============================================================================

@Repository
interface ProgrammeRoomsRepository extends JpaRepository<ProgrammeRooms, Long> {
    List<ProgrammeRooms> findByScheduleId(Long scheduleId);
    List<ProgrammeRooms> findByRoomId(Long roomId);
    List<ProgrammeRooms> findByDayHourId(Integer dayHourId);

    @Query("SELECT pr FROM ProgrammeRooms pr WHERE pr.room.id = :roomId AND pr.dayHourId = :dayHourId AND pr.schedule.id = :scheduleId")
    List<ProgrammeRooms> findByRoomAndDayHourAndSchedule(
        @Param("roomId") Long roomId,
        @Param("dayHourId") Integer dayHourId,
        @Param("scheduleId") Long scheduleId
    );

    void deleteByScheduleId(Long scheduleId);
}

@Repository
interface ProgrammeHistoryRepository extends JpaRepository<ProgrammeHistory, Long> {
    List<ProgrammeHistory> findByScheduleId(Long scheduleId);
    List<ProgrammeHistory> findByType(String type);
}

@Repository
interface ProgrammeRoomsHistoryRepository extends JpaRepository<ProgrammeRoomsHistory, Long> {
    List<ProgrammeRoomsHistory> findByScheduleId(Long scheduleId);
}

// ============================================================================
// EXAM REPOSITORIES
// ============================================================================

@Repository
interface ExamDayRepository extends JpaRepository<ExamDay, Long> {
    Optional<ExamDay> findByName(String name);
}

@Repository
interface ExamProgrammeRepository extends JpaRepository<ExamProgramme, Long> {
    List<ExamProgramme> findByScheduleId(Long scheduleId);
    List<ExamProgramme> findByUserId(Long userId);

    @Query("SELECT ep FROM ExamProgramme ep WHERE ep.day.id = :dayId AND ep.hour.id = :hourId AND ep.schedule.id = :scheduleId")
    List<ExamProgramme> findByDayAndHourAndSchedule(
        @Param("dayId") Long dayId,
        @Param("hourId") Long hourId,
        @Param("scheduleId") Long scheduleId
    );
}

@Repository
interface ExamProgrammeRoomsRepository extends JpaRepository<ExamProgrammeRooms, Long> {
    List<ExamProgrammeRooms> findByRoomId(Long roomId);
    List<ExamProgrammeRooms> findByDayHourId(Integer dayHourId);
    List<ExamProgrammeRooms> findByActive(ExamProgrammeRooms.ActiveStatus active);
}

// ============================================================================
// NOTIFICATION & OTHER REPOSITORIES
// ============================================================================

@Repository
interface NotificationRepository extends JpaRepository<Notification, Long> {
    List<Notification> findByStatus(Integer status);
    List<Notification> findByUserId(Long userId);
    List<Notification> findByDepartmentId(Long departmentId);

    @Query("SELECT COUNT(n) FROM Notification n WHERE n.status = 0")
    Long countPendingNotifications();

    @Query("SELECT n FROM Notification n WHERE n.status = 0 ORDER BY n.createdAt DESC")
    List<Notification> findAllPending();
}

@Repository
interface MyCourseRepository extends JpaRepository<MyCourse, Long> {
    List<MyCourse> findByUserId(Long userId);
    List<MyCourse> findByCourseId(Long courseId);

    @Query("SELECT mc FROM MyCourse mc WHERE mc.user.id = :userId AND mc.course.id = :courseId")
    Optional<MyCourse> findByUserAndCourse(@Param("userId") Long userId, @Param("courseId") Long courseId);

    void deleteByUserIdAndCourseId(Long userId, Long courseId);
}

@Repository
interface PasswordRepository extends JpaRepository<Password, Long> {
    Optional<Password> findByUserId(Long userId);
}

@Repository
interface UserTypeRepository extends JpaRepository<UserType, Long> {
    Optional<UserType> findByType(String type);
}

@Repository
interface EquipmentRoomRepository extends JpaRepository<EquipmentRoom, Long> {
    List<EquipmentRoom> findByRoomId(Long roomId);
    List<EquipmentRoom> findByEquipmentId(Long equipmentId);
    List<EquipmentRoom> findByDepartmentId(Long departmentId);
}

@Repository
interface RoomDepartRepository extends JpaRepository<RoomDepart, Long> {
    List<RoomDepart> findByRoomId(Long roomId);
    List<RoomDepart> findByDepartmentId(Long departmentId);
}

@Repository
interface EquipmentDepartRepository extends JpaRepository<EquipmentDepart, Long> {
    List<EquipmentDepart> findByEquipmentId(Long equipmentId);
    List<EquipmentDepart> findByDepartmentId(Long departmentId);
}

@Repository
interface AdminSemRepository extends JpaRepository<AdminSem, Long> {
    List<AdminSem> findByDepartmentId(Long departmentId);
    Optional<AdminSem> findByDepartmentIdAndSemesterId(Long departmentId, Integer semesterId);
}
