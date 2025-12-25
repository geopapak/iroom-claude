package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.CourseKateuthinsi;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface CourseKateuthinsiRepository extends JpaRepository<CourseKateuthinsi, Long> {
    List<CourseKateuthinsi> findByCourseId(Long courseId);
    List<CourseKateuthinsi> findByKateuthinsiId(Long kateuthinsiId);
}
