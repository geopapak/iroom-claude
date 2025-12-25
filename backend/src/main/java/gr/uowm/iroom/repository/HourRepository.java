package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.Hour;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface HourRepository extends JpaRepository<Hour, Long> {
    List<Hour> findAllByOrderByStartHourAsc();
}
