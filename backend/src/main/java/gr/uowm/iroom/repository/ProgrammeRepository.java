package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.Programme;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface ProgrammeRepository extends JpaRepository<Programme, Long> {

    List<Programme> findByScheduleId(Long scheduleId);

    List<Programme> findByUserId(Long userId);

    @Query("SELECT p FROM Programme p WHERE p.user.id = :userId AND p.schedule.id = :scheduleId")
    List<Programme> findByUserIdAndScheduleId(@Param("userId") Long userId, @Param("scheduleId") Long scheduleId);

    @Query("SELECT p FROM Programme p WHERE p.day.id = :dayId AND p.hour.id = :hourId AND p.schedule.id = :scheduleId")
    List<Programme> findByDayAndHourAndSchedule(
        @Param("dayId") Long dayId,
        @Param("hourId") Long hourId,
        @Param("scheduleId") Long scheduleId
    );

    @Query("SELECT p FROM Programme p WHERE p.user.id = :userId AND p.day.id = :dayId AND p.hour.id = :hourId AND p.schedule.id = :scheduleId")
    List<Programme> findByUserAndDayAndHourAndSchedule(
        @Param("userId") Long userId,
        @Param("dayId") Long dayId,
        @Param("hourId") Long hourId,
        @Param("scheduleId") Long scheduleId
    );

    @Query("SELECT p FROM Programme p WHERE p.semesterCourse.department.id = :departmentId AND p.schedule.id = :scheduleId")
    List<Programme> findByDepartmentAndSchedule(@Param("departmentId") Long departmentId, @Param("scheduleId") Long scheduleId);

    void deleteByScheduleId(Long scheduleId);
}
