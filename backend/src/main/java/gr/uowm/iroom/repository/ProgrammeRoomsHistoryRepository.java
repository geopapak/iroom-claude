package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.ProgrammeRoomsHistory;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface ProgrammeRoomsHistoryRepository extends JpaRepository<ProgrammeRoomsHistory, Long> {
    List<ProgrammeRoomsHistory> findByScheduleId(Long scheduleId);
}
