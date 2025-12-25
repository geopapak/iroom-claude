package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.EquipmentDepart;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface EquipmentDepartRepository extends JpaRepository<EquipmentDepart, Long> {
    List<EquipmentDepart> findByEquipmentId(Long equipmentId);
    List<EquipmentDepart> findByDepartmentId(Long departmentId);
}
