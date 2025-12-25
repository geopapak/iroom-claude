package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.ProgrammeRooms;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface ProgrammeRoomsRepository extends JpaRepository<ProgrammeRooms, Long> {
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
