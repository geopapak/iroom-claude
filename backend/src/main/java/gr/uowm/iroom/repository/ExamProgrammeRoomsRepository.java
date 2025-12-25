package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.ExamProgrammeRooms;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface ExamProgrammeRoomsRepository extends JpaRepository<ExamProgrammeRooms, Long> {
    List<ExamProgrammeRooms> findByRoomId(Long roomId);
    List<ExamProgrammeRooms> findByDayHourId(Integer dayHourId);
    List<ExamProgrammeRooms> findByActive(ExamProgrammeRooms.ActiveStatus active);
}
