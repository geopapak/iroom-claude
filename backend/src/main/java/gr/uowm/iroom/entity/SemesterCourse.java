package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Links courses to semesters and departments
 */
@Entity
@Table(name = "semester_course")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class SemesterCourse extends BaseEntity {

    @NotNull(message = "Course is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_course", nullable = false)
    private Course course;

    @NotNull(message = "Semester is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_semester", nullable = false)
    private Semester semester;

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_depart", nullable = false)
    private Department department;
}
