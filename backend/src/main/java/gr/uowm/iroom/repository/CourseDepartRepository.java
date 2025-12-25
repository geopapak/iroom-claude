package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.CourseDepart;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface CourseDepartRepository extends JpaRepository<CourseDepart, Long> {
    List<CourseDepart> findByCourseId(Long courseId);
    List<CourseDepart> findByDepartmentId(Long departmentId);
}
