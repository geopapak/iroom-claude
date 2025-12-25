package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.CourseProfessor;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface CourseProfessorRepository extends JpaRepository<CourseProfessor, Long> {
    List<CourseProfessor> findByCourseId(Long courseId);
    List<CourseProfessor> findByProfessorId(Long professorId);

    @Query("SELECT cp FROM CourseProfessor cp WHERE cp.course.id = :courseId AND cp.department.id = :departmentId")
    List<CourseProfessor> findByCourseAndDepartment(@Param("courseId") Long courseId, @Param("departmentId") Long departmentId);
}
