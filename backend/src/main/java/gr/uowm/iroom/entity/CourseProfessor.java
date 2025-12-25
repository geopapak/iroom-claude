package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Links courses to professors
 */
@Entity
@Table(name = "course_profesor")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class CourseProfessor extends BaseEntity {

    @NotNull(message = "Course is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_course", nullable = false)
    private Course course;

    @NotNull(message = "Professor is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_profesor", nullable = false)
    private User professor;

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_depart", nullable = false)
    private Department department;
}
