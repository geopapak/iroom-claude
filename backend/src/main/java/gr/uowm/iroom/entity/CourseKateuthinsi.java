package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Links courses to kateuthinsi (academic tracks)
 */
@Entity
@Table(name = "course_kateuthinsi")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class CourseKateuthinsi extends BaseEntity {

    @NotNull(message = "Course is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_course", nullable = false)
    private Course course;

    @NotNull(message = "Kateuthinsi is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_kat", nullable = false)
    private Kateuthinsi kateuthinsi;

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_department", nullable = false)
    private Department department;
}
