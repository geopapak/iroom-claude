package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.AdminSem;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface AdminSemRepository extends JpaRepository<AdminSem, Long> {
    List<AdminSem> findByDepartmentId(Long departmentId);
    Optional<AdminSem> findByDepartmentIdAndSemesterId(Long departmentId, Integer semesterId);
}
