package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.SemesterCourse;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface SemesterCourseRepository extends JpaRepository<SemesterCourse, Long> {
    List<SemesterCourse> findBySemesterId(Long semesterId);
    List<SemesterCourse> findByDepartmentId(Long departmentId);
    List<SemesterCourse> findByCourseId(Long courseId);

    @Query("SELECT sc FROM SemesterCourse sc WHERE sc.course.id = :courseId AND sc.semester.id = :semesterId AND sc.department.id = :departmentId")
    Optional<SemesterCourse> findByCourseAndSemesterAndDepartment(
        @Param("courseId") Long courseId,
        @Param("semesterId") Long semesterId,
        @Param("departmentId") Long departmentId
    );
}
