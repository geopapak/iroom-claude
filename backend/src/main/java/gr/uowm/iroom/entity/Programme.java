package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Programme entity (class schedule)
 */
@Entity
@Table(name = "programme")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class Programme extends BaseEntity {

    @NotNull(message = "Semester course is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_semester_course", nullable = false)
    private SemesterCourse semesterCourse;

    @NotNull(message = "Day is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_day", nullable = false)
    private Day day;

    @NotNull(message = "Hour is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_hour", nullable = false)
    private Hour hour;

    @NotNull(message = "User is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_user", nullable = false)
    private User user; // Professor

    @NotNull(message = "Schedule is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_schedule", nullable = false)
    private Schedule schedule;
}
