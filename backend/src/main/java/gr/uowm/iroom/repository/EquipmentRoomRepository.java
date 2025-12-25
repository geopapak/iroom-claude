package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.EquipmentRoom;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface EquipmentRoomRepository extends JpaRepository<EquipmentRoom, Long> {
    List<EquipmentRoom> findByRoomId(Long roomId);
    List<EquipmentRoom> findByEquipmentId(Long equipmentId);
    List<EquipmentRoom> findByDepartmentId(Long departmentId);
}
