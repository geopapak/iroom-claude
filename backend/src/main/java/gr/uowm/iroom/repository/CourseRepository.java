package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.Course;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface CourseRepository extends JpaRepository<Course, Long> {

    Optional<Course> findByCode(String code);

    List<Course> findByYear(Integer year);

    List<Course> findByOptional(Course.OptionalStatus optional);

    @Query("SELECT c FROM Course c JOIN c.semesterCourses sc WHERE sc.department.id = :departmentId")
    List<Course> findByDepartmentId(@Param("departmentId") Long departmentId);

    @Query("SELECT c FROM Course c JOIN c.semesterCourses sc WHERE sc.semester.id = :semesterId")
    List<Course> findBySemesterId(@Param("semesterId") Long semesterId);

    boolean existsByCode(String code);
}
