package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.ProgrammeHistory;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface ProgrammeHistoryRepository extends JpaRepository<ProgrammeHistory, Long> {
    List<ProgrammeHistory> findByScheduleId(Long scheduleId);
    List<ProgrammeHistory> findByType(String type);
}
