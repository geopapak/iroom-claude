package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Historical room assignments
 */
@Entity
@Table(name = "programme_rooms_history")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class ProgrammeRoomsHistory extends BaseEntity {

    @Column(name = "ID_day_hour")
    private Integer dayHourId;

    @NotNull(message = "Room is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_room", nullable = false)
    private Room room;

    @NotNull(message = "Course is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_course", nullable = false)
    private Course course;

    @NotNull(message = "Schedule is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_schedule", nullable = false)
    private Schedule schedule;
}
