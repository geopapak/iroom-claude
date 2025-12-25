package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.RoomDepart;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface RoomDepartRepository extends JpaRepository<RoomDepart, Long> {
    List<RoomDepart> findByRoomId(Long roomId);
    List<RoomDepart> findByDepartmentId(Long departmentId);
}
