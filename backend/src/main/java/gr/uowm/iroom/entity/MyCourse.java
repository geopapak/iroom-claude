package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Student course selections
 */
@Entity
@Table(name = "my_course")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class MyCourse extends BaseEntity {

    @NotNull(message = "User is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_user", nullable = false)
    private User user; // Student

    @NotNull(message = "Course is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_course", nullable = false)
    private Course course;
}
