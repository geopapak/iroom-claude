package gr.uowm.iroom.repository;

import gr.uowm.iroom.entity.MyCourse;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface MyCourseRepository extends JpaRepository<MyCourse, Long> {
    List<MyCourse> findByUserId(Long userId);
    List<MyCourse> findByCourseId(Long courseId);

    @Query("SELECT mc FROM MyCourse mc WHERE mc.user.id = :userId AND mc.course.id = :courseId")
    Optional<MyCourse> findByUserAndCourse(@Param("userId") Long userId, @Param("courseId") Long courseId);

    void deleteByUserIdAndCourseId(Long userId, Long courseId);
}
