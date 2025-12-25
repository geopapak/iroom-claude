package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.ExamDay;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.Optional;

@Repository
public interface ExamDayRepository extends JpaRepository<ExamDay, Long> {
    Optional<ExamDay> findByName(String name);
}
