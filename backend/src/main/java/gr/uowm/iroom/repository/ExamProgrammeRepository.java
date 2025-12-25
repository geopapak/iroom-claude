package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.ExamProgramme;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface ExamProgrammeRepository extends JpaRepository<ExamProgramme, Long> {
    List<ExamProgramme> findByScheduleId(Long scheduleId);
    List<ExamProgramme> findByUserId(Long userId);

    @Query("SELECT ep FROM ExamProgramme ep WHERE ep.day.id = :dayId AND ep.hour.id = :hourId AND ep.schedule.id = :scheduleId")
    List<ExamProgramme> findByDayAndHourAndSchedule(
        @Param("dayId") Long dayId,
        @Param("hourId") Long hourId,
        @Param("scheduleId") Long scheduleId
    );
}
