package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.Schedule;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface ScheduleRepository extends JpaRepository<Schedule, Long> {
    Optional<Schedule> findByName(String name);
    List<Schedule> findAllByOrderByNameDesc();
}
