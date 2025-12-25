package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Room assignments for exams
 */
@Entity
@Table(name = "exam_programme_rooms")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class ExamProgrammeRooms extends BaseEntity {

    @Column(name = "ID_day_hour")
    private Integer dayHourId;

    @NotNull(message = "Room is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_room", nullable = false)
    private Room room;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_course")
    private Course course;

    @NotNull(message = "Active status is required")
    @Enumerated(EnumType.STRING)
    @Column(name = "active", nullable = false, length = 8)
    private ActiveStatus active;

    public enum ActiveStatus {
        active, inactive
    }
}
