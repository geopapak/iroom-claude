package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.Department;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface DepartmentRepository extends JpaRepository<Department, Long> {
    List<Department> findByUniversityId(Long universityId);
    Optional<Department> findBySsoDepart(Integer ssoDepart);
}
