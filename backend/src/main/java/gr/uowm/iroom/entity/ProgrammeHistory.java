package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Historical record of class schedules
 */
@Entity
@Table(name = "programme_history")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class ProgrammeHistory extends BaseEntity {

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
    private User user;

    @NotNull(message = "Schedule is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_schedule", nullable = false)
    private Schedule schedule;

    @NotBlank(message = "Type is required")
    @Column(name = "type", nullable = false, length = 10)
    private String type; // Semester type (spring/winter)
}
