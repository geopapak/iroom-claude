package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.Kateuthinsi;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface KateuthinsiRepository extends JpaRepository<Kateuthinsi, Long> {
    List<Kateuthinsi> findByDepartmentId(Long departmentId);
}
