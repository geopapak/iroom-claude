package gr.uowm.iroom.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotNull;
import lombok.*;

/**
 * Room assignments for scheduled classes
 */
@Entity
@Table(name = "programme_rooms")
@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
@Builder
public class ProgrammeRooms extends BaseEntity {

    @Column(name = "ID_day_hour")
    private Integer dayHourId; // Concatenated day+hour ID

    @NotNull(message = "Room is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_room", nullable = false)
    private Room room;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_course")
    private Course course;

    @NotNull(message = "Department is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_departament", nullable = false)
    private Department department;

    @NotNull(message = "Schedule is required")
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "ID_schedule", nullable = false)
    private Schedule schedule;
}
